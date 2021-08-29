<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Pdo,
    Settings,
    Valid
};

/**
 * Login
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Login {

    public static $login_error = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->logout();
        $this->login();
        $this->loginError();
        $this->afterInstall();
        $this->autorize();
    }

    /**
     * Logout
     *
     */
    public function logout() {
        session_start();
        if (Valid::inGET('logout') == 'ok') {
            unset($_SESSION['login']);
            unset($_SESSION['pass']);
            header('Location: ?route=login');
        }
    }

    /**
     * Login
     *
     */
    public function login() {
        if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
            if (isset($_SESSION['session_page'])) {
                $session_page = $_SESSION['session_page'];
                unset($_SESSION['session_page']);
                header('Location: ' . $session_page);
            } else {
                header('Location: ?route=dashboard');
            }
        }
    }

    /**
     * Login Error
     *
     */
    public function loginError() {
        if (isset($_SESSION['login_error']) == TRUE && Valid::inPOST('login') && Valid::inPOST('pass')) {
            unset($_SESSION['login']);
            unset($_SESSION['pass']);
            self::$login_error = $_SESSION['login_error'];
        }
    }

    /**
     * After Install
     *
     */
    public function afterInstall() {
        if (Valid::inPOST('install') == 'ok') {
            session_destroy();
            session_start();
        }
    }

    /**
     * Autorize
     *
     */
    public function autorize() {
        if (Valid::inPOST('autorize') == 'ok') {
            $_SESSION['DEFAULT_LANGUAGE'] = Settings::basicSettings('primary_language');
            $HASH = Pdo::getValue("SELECT password FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [Valid::inPOST('login')]);
            if (!password_verify(Valid::inPOST('pass'), $HASH)) {
                unset($_SESSION['login']);
                unset($_SESSION['pass']);
                $_SESSION['login_error'] = lang('login_error');
                Messages::alert('login_error', 'danger', self::$login_error, 7000, true);
            } else {
                $_SESSION['login'] = Valid::inPOST('login');
                $_SESSION['pass'] = $HASH;
                $_SESSION['DEFAULT_LANGUAGE'] = Settings::basicSettings('primary_language');
                if (isset($_SESSION['session_page'])) {
                    $session_page = $_SESSION['session_page'];
                    unset($_SESSION['session_page']);
                    if ($session_page == '/controller/admin/') {
                        $session_page = '?route=dashboard';
                    }
                    Messages::alert('autorize', 'success', lang('action_completed_successfully'), 0, true);
                    header('Location: ' . $session_page);
                } else {
                    Messages::alert('autorize', 'success', lang('action_completed_successfully'), 0, true);
                    header('Location: ?route=dashboard');
                }
            }
        }
    }

}
