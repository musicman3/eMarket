<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

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
class Autorize {

    public static $customer;
    public static $csrf_token = FALSE;

    /**
     * Constructor
     *
     */
    public function __construct() {

        if (Settings::path() == 'admin' && Valid::inGET('route') != 'login') {
            session_start();
            $this->csrfVerification();
            $_SESSION['csrf_token'] = self::csrfToken();
            $this->sessionAdmin();
        }

        if (Settings::path() == 'catalog') {
            session_start();
            $this->csrfVerification();
            $_SESSION['csrf_token'] = self::csrfToken();
            $this->sessionCatalog();
            new Cart();
        }
    }

    /**
     * CSRF Token
     *
     * @return string CSRF token
     */
    public static function csrfToken() {

        if (self::$csrf_token == FALSE) {
            self::$csrf_token = Func::getToken(32);
        }

        return self::$csrf_token;
    }

    /**
     * CSRF Verification
     *
     */
    public function csrfVerification() {

        if (Valid::isPOST() == TRUE) {
            if (!Valid::inPOST('csrf_token') || !isset($_SESSION['csrf_token']) || Valid::inPOST('csrf_token') != $_SESSION['csrf_token']) {
                exit;
            }
        }
    }

    /**
     * Demo mode init
     *
     */
    public function demoModeInit() {
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
    public function dashboardCheck() {
        if (isset($_SESSION['login'])) {
            $staff_permission = Pdo::getValue("SELECT permission FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [$_SESSION['login']]);
            if ($staff_permission != 'admin') {
                $staff_data = json_decode(Pdo::getValue("SELECT permissions FROM " . TABLE_STAFF_MANAGER . " WHERE id=?", [$staff_permission]), 1);

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
                }
            }
        }
    }

    /**
     * Session authorization for Admin Panel
     *
     * @return string TRUE
     */
    public function sessionAdmin() {

        if (Settings::path() == 'admin' && Settings::titleDir() != 'login') {

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
                return TRUE;
            } else {
                $_SESSION['DEFAULT_LANGUAGE'] = Settings::basicSettings('primary_language');
                return TRUE;
            }
        }
    }

    /**
     * Session authorization for Catalog
     *
     */
    public function sessionCatalog() {

        if (Settings::path() == 'catalog') {

            if (isset($_SESSION['email_customer'])) {
                $customer_data = Pdo::getAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
            } else {
                $customer_data['status'] = 0;
            }

            if (isset($_SESSION['customer_session_start']) && (time() - $_SESSION['customer_session_start']) / 60 > Settings::sessionExprTime() OR $customer_data['status'] == 0) {
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
        }
    }

    /**
     * Password hashing
     *
     * @param string Password
     * @return string $password Hash
     */
    public static function passwordHash($password) {

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
