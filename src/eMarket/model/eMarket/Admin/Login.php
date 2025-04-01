<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Settings,
    Valid
};
use Cruder\Db;

/**
 * Login
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Login {

    public static $routing_parameter = 'login';
    public $title = 'title_login_index';
    public static $login_error = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        session_start();
        $this->logout();
        $this->login();
        $this->loginError();
        $this->afterInstall();
        $this->authorize();
    }

    /**
     * Logout
     *
     */
    private function logout(): void {
        if (Valid::inGET('logout') == 'ok') {
            unset($_SESSION['login']);
            unset($_SESSION['pass']);
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Login
     *
     */
    private function login(): void {
        if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
            if (isset($_SESSION['session_page'])) {
                $session_page = $_SESSION['session_page'];
                unset($_SESSION['session_page']);
                header('Location: ' . $session_page);
                exit;
            } else {
                header('Location: ?route=' . Settings::defaultPage());
                exit;
            }
        }
    }

    /**
     * Login Error
     *
     */
    private function loginError(): void {
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
    private function afterInstall(): void {
        if (Valid::inPOST('install') == 'ok') {
            session_destroy();
            session_start();
        }
    }

    /**
     * Authorize
     *
     */
    private function authorize(): void {
        if (Valid::inPOST('authorize') == 'ok') {
            $_SESSION['DEFAULT_LANGUAGE'] = Settings::basicSettings('primary_language');

            $HASH = (string) Db::connect()
                            ->read(TABLE_ADMINISTRATORS)
                            ->selectValue('password')
                            ->where('login=', Valid::inPOST('login'))
                            ->save();

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
                        $session_page = '?route=' . Settings::defaultPage();
                    }
                    header('Location: ' . $session_page);
                    exit;
                } else {
                    header('Location: ?route=' . Settings::defaultPage());
                    exit;
                }
            }
        }
    }

}
