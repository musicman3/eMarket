<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
    Settings,
    Valid
};
use \eMarket\Catalog\{
    Cart
};

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

    /**
     * Constructor
     *
     */
    public function __construct() {
        $exceptions = FALSE;

        if (strrpos(Valid::inSERVER('REQUEST_URI'), 'controller/admin/blanks/')) {
            $exceptions = 'blanks';
        }

        if (Settings::path() == 'admin' && Valid::inGET('route') != 'login' && !$exceptions) {
            session_start();
            $this->csrfVerification();
            $this->admin();
        }

        if (Settings::path() == 'catalog' && !$exceptions) {
            session_start();
            $this->csrfVerification();
            $this->catalog();
            new Cart();
        }

        if (Settings::path() == 'install' && !$this->installVerify()) {
            exit;
        }
    }

    /**
     * Checking for install
     * Thanks to alexanderpas (https://github.com/alexanderpas)
     *
     * @return bool TRUE/FALSE
     */
    private function installVerify(): bool {
        if (file_exists(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php') && file_exists(getenv('DOCUMENT_ROOT') . '/.htaccess')) {
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
            self::$csrf_token = Func::getToken(32);
            $_SESSION['csrf_token_' . Settings::path()] = self::$csrf_token;
        }
        return self::$csrf_token;
    }

    /**
     * CSRF Verification
     *
     */
    private function csrfVerification(): void {

        if (Valid::isPOST()) {
            if (!Valid::inPOST('csrf_token') || Valid::inPOST('csrf_token') != $_SESSION['csrf_token_' . Settings::path()]) {
                exit;
            }
        }
        if (Valid::isPostJson()) {
            if (!Valid::inPostJson('csrf_token') || Valid::inPostJson('csrf_token') != $_SESSION['csrf_token_' . Settings::path()]) {
                exit;
            }
        }
    }

    /**
     * Demo mode init
     *
     */
    private function demoModeInit(): void {
        if (isset($_SESSION['login'])) {
            $staff_permission = Pdo::getValue("SELECT permission FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [$_SESSION['login']]);
            if ($staff_permission != 'admin') {
                $mode = Pdo::getValue("SELECT mode FROM " . TABLE_STAFF_MANAGER . " WHERE id=?", [$staff_permission]);
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
            $staff_permission = Pdo::getValue("SELECT permission FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [$_SESSION['login']]);
            if ($staff_permission != 'admin') {
                $staff_data = json_decode(Pdo::getValue("SELECT permissions FROM " . TABLE_STAFF_MANAGER . " WHERE id=?", [$staff_permission]), true);
                $count = 0;
                foreach ($staff_data as $value) {
                    if ($value == '?route=dashboard') {
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

        if (isset($_SESSION['session_start']) && (time() - $_SESSION['session_start']) / 60 > Settings::sessionExprTime()) {
            unset($_SESSION['login']);
            unset($_SESSION['pass']);
            unset($_SESSION['session_start']);
            $_SESSION['session_page'] = Valid::inSERVER('REQUEST_URI');
            header('Location: ?route=login');
            exit;
        }
        $_SESSION['session_start'] = time();

        if (!isset($_SESSION['login'])) {
            unset($_SESSION['login']);
            unset($_SESSION['pass']);
            $_SESSION['session_page'] = Valid::inSERVER('REQUEST_URI');
            header('Location: ?route=login');
            exit;
        } elseif (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
            $_SESSION['DEFAULT_LANGUAGE'] = Pdo::getValue("SELECT language FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [
                        $_SESSION['login'], $_SESSION['pass']
            ]);
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

        if (isset($_SESSION['email_customer'])) {
            $customer_data = Pdo::getAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
        } else {
            $customer_data['status'] = 0;
        }

        if (isset($_SESSION['customer_session_start']) && (time() - $_SESSION['customer_session_start']) / 60 > Settings::sessionExprTime() || $customer_data['status'] == 0) {
            unset($_SESSION['password_customer']);
            unset($_SESSION['email_customer']);
            unset($_SESSION['customer_session_start']);
            return FALSE;
        }
        $_SESSION['customer_session_start'] = time();

        if (!isset($_SESSION['email_customer'])) {
            self::$customer = FALSE;
        } else {
            self::$customer = $customer_data;
        }

        return TRUE;
    }

    /**
     * Password hashing
     *
     * @param string Password
     * @return string $password Hash
     */
    public static function passwordHash(string $password): string {

        if (HASH_METHOD == 'PASSWORD_DEFAULT') {
            $options = ['cost' => 10];
            $METHOD = PASSWORD_DEFAULT;
        }
        if (HASH_METHOD == 'PASSWORD_BCRYPT') {
            $options = ['cost' => 10];
            $METHOD = PASSWORD_BCRYPT;
        }
        if (HASH_METHOD == 'PASSWORD_ARGON2I') {
            $options = ['time_cost' => 2];
            $METHOD = PASSWORD_ARGON2I;
        }
        $password_hash = password_hash($password, $METHOD, $options);

        return $password_hash;
    }

}
