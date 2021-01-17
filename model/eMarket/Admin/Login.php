<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

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
        if (\eMarket\Core\Valid::inGET('logout') == 'ok') {
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
        if (isset($_SESSION['login_error']) == TRUE && \eMarket\Core\Valid::inPOST('login') && \eMarket\Core\Valid::inPOST('pass')) {
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
        if (\eMarket\Core\Valid::inPOST('install') == 'ok') {
            session_destroy();
            session_start();
        }
    }

    /**
     * Autorize
     *
     */
    public function autorize() {
        if (\eMarket\Core\Valid::inPOST('autorize') == 'ok') {
            $_SESSION['DEFAULT_LANGUAGE'] = \eMarket\Core\Settings::basicSettings('primary_language');
            $HASH = \eMarket\Core\Pdo::selectPrepare("SELECT password FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [\eMarket\Core\Valid::inPOST('login')]);
            if (!password_verify(\eMarket\Core\Valid::inPOST('pass'), $HASH)) {
                unset($_SESSION['login']);
                unset($_SESSION['pass']);
                $_SESSION['login_error'] = lang('login_error');
            } else {
                $_SESSION['login'] = \eMarket\Core\Valid::inPOST('login');
                $_SESSION['pass'] = $HASH;
                $_SESSION['DEFAULT_LANGUAGE'] = \eMarket\Core\Settings::basicSettings('primary_language');
                if (isset($_SESSION['session_page'])) {
                    $session_page = $_SESSION['session_page'];
                    unset($_SESSION['session_page']);
                    header('Location: ' . $session_page);
                } else {
                    header('Location: ?route=dashboard');
                }
            }
        }
    }

}
