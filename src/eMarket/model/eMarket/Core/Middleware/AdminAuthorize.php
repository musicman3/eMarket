<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Middleware;

use eMarket\Core\{
    Cryptography,
    Settings,
    Routing,
    Lang,
    Clock\SystemClock
};
use R2D2\R2\Valid;
use Cruder\Db;

/**
 * Class for admin authorization
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class AdminAuthorize {

    public static $csrf_token = FALSE;
    public static $permission = FALSE;

    /**
     * Constructor
     *
     */
    public function __construct() {

        if (Valid::inGET('route') == 'login' || Settings::path() == 'uploads') {
            return;
        }

        session_start();
        $this->csrfVerification();

        $this->permission();
        $this->admin();
        // Load Languages
        new Lang();
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
