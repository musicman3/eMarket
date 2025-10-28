<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Cryptography,
    Settings,
    Valid,
    Routing,
    Clock\SystemClock
};
use \eMarket\Catalog\{
    Cart
};
use Cruder\Db;

/**
 * Class for user authorization
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Authorize {

    public static $customer;
    public static $csrf_token = FALSE;
    public static $permission = FALSE;

    /**
     * Constructor
     *
     */
    public function __construct() {

        $this->currencyCheck();
        $this->langCheck();

        if (Settings::path() == 'admin' && Valid::inGET('route') == 'login' || Settings::path() == 'uploads') {
            return;
        }

        session_start();
        if (Settings::path() != 'install') {
            $this->csrfVerification();
        }

        if (Settings::path() == 'admin' && Valid::inGET('route') != 'login') {
            $this->permission();
            $this->admin();
        }

        if (Settings::path() == 'catalog') {
            $this->catalog();
            new Cart();
        }

        if (Settings::path() == 'install' && !$this->installVerify()) {
            echo 'Error! Installation already completed!';
            exit;
        }
    }

    /**
     * Checking the availability of currency
     *
     * @return bool FALSE
     */
    private function currencyCheck(): bool {

        if (Valid::inGET('currency_default')) {
            $currency = Db::connect()
                    ->read(TABLE_CURRENCIES)
                    ->selectValue('name')
                    ->where('id=', Valid::inGET('currency_default'))
                    ->save();
            if ($currency == false) {
                header('Location: /');
                exit;
            }
        }
        return false;
    }

    /**
     * Checking the availability of language
     *
     * @return bool FALSE
     */
    private function langCheck(): bool {

        if (Valid::inGET('language') && !file_exists(getenv('DOCUMENT_ROOT') . '/language/' . Valid::inGET('language'))) {
            header('Location: /');
            exit;
        }

        return false;
    }

    /**
     * Checking for install
     * Thanks to alexanderpas (https://github.com/alexanderpas)
     *
     * @return bool TRUE/FALSE
     */
    private function installVerify(): bool {
        if (file_exists(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php')) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * CSRF Token
     *
     * @return string CSRF token
     */
    public static function csrfToken(): string {

        if (!self::$csrf_token) {
            self::$csrf_token = Cryptography::getToken(32);
            $_SESSION['csrf_token_' . Settings::path()] = self::$csrf_token;
        }
        return self::$csrf_token;
    }

    /**
     * CSRF Verification
     *
     */
    private function csrfVerification(): void {

        if (!isset($_SESSION[Settings::$csrf[Settings::path()]])) {
            $csrf_session_token = self::csrfToken();
        } else {
            $csrf_session_token = $_SESSION[Settings::$csrf[Settings::path()]];
        }

        if (Valid::isPOST()) {
            if (!Valid::inPOST('csrf_token') || Valid::inPOST('csrf_token') != $csrf_session_token) {
                echo 'CSRF Token Error!';
                exit;
            }
        }

        if (Valid::isPostJson()) {
            if (Settings::path() != 'JsonRpc') {
                if (!Valid::inPostJson('csrf_token') || Valid::inPostJson('csrf_token') != $csrf_session_token) {
                    echo 'CSRF Token Error!';
                    exit;
                }
            }
        }
    }

    /**
     * Permission
     *
     */
    private function permission(): void {
        if (isset($_SESSION['login'])) {

            self::$permission = Db::connect()
                    ->read(TABLE_ADMINISTRATORS)
                    ->selectValue('permission')
                    ->where('login=', $_SESSION['login'])
                    ->save();
        }
    }

    /**
     * Demo mode init
     *
     */
    private function demoModeInit(): void {
        if (isset($_SESSION['login'])) {

            if (self::$permission != 'admin') {

                $mode = Db::connect()
                        ->read(TABLE_STAFF_MANAGER)
                        ->selectValue('mode')
                        ->where('id=', self::$permission)
                        ->save();

                if ($mode == 1) {
                    Valid::$demo_mode = TRUE;
                }
            }
        }
    }

    /**
     * Dashboard check
     *
     */
    private function dashboardCheck(): void {
        if (isset($_SESSION['login'])) {

            if (self::$permission != 'admin') {

                $staff_data_prepare = Db::connect()
                        ->read(TABLE_STAFF_MANAGER)
                        ->selectValue('permissions')
                        ->where('id=', self::$permission)
                        ->save();

                $staff_data = json_decode($staff_data_prepare, true);

                $count = 0;
                foreach ($staff_data as $value) {
                    if ($value == '?route=' . Routing::indexRoute()) {
                        $count++;
                    }
                }
                if ($count == 0) {
                    unset($_SESSION['login']);
                    unset($_SESSION['pass']);
                    header('Location: ?route=login');
                    exit;
                }
            }
        }
    }

    /**
     * Session authorization for Admin Panel
     *
     * @return bool TRUE
     */
    private function admin(): bool {

        $this->demoModeInit();
        $this->dashboardCheck();
        $new_datestamp = SystemClock::nowUnixTime();

        if (isset($_SESSION['session_start']) && ($new_datestamp - $_SESSION['session_start']) / 60 > Settings::adminSessionTime()) {
            unset($_SESSION['login']);
            unset($_SESSION['pass']);
            unset($_SESSION['session_start']);
            $_SESSION['session_page'] = Valid::inSERVER('REQUEST_URI');
            header('Location: ?route=login');
            exit;
        }
        $_SESSION['session_start'] = $new_datestamp;

        if (!isset($_SESSION['login'])) {
            unset($_SESSION['login']);
            unset($_SESSION['pass']);
            $_SESSION['session_page'] = Valid::inSERVER('REQUEST_URI');
            header('Location: ?route=login');
            exit;
        } elseif (isset($_SESSION['login']) && isset($_SESSION['pass'])) {

            $_SESSION['DEFAULT_LANGUAGE'] = Db::connect()
                    ->read(TABLE_ADMINISTRATORS)
                    ->selectValue('language')
                    ->where('login=', $_SESSION['login'])
                    ->and('password=', $_SESSION['pass'])
                    ->save();
        } else {
            $_SESSION['DEFAULT_LANGUAGE'] = Settings::basicSettings('primary_language');
        }

        return TRUE;
    }

    /**
     * Session authorization for Catalog
     *
     * @return bool TRUE|FALSE
     */
    private function catalog(): bool {

        $new_datestamp = SystemClock::nowUnixTime();

        if (isset($_SESSION['customer_email'])) {

            $customer_data = Db::connect()
                            ->read(TABLE_CUSTOMERS)
                            ->selectAssoc('*')
                            ->where('email=', $_SESSION['customer_email'])
                            ->save()[0];
        } else {
            $customer_data['status'] = 0;
        }

        if (isset($_SESSION['customer_session_start']) && ($new_datestamp - $_SESSION['customer_session_start']) / 60 > Settings::adminSessionTime() || $customer_data['status'] == 0) {
            unset($_SESSION['customer_password']);
            unset($_SESSION['customer_email']);
            unset($_SESSION['customer_session_start']);
            return FALSE;
        }
        $_SESSION['customer_session_start'] = $new_datestamp;

        if (!isset($_SESSION['customer_email'])) {
            self::$customer = FALSE;
        } else {
            self::$customer = $customer_data;
        }

        return TRUE;
    }

    /**
     * Encrypted Login
     *
     * @return string encrypted login
     */
    public static function encryptedLogin(): string {

        if (isset($_SESSION['login']) && $_SESSION['pass']) {
            return Cryptography::encryption(DB_PASSWORD, $_SESSION['login'], CRYPT_METHOD);
        }
        return 'false';
    }
}
