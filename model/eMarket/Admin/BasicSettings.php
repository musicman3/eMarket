<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Messages,
    Pdo,
    Settings,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Basic Settings
 *
 * @package Admin
 * @author eMarket
 * 
 */
class BasicSettings {

    public static $lines_on_page = FALSE;
    public static $session_expr_time = FALSE;
    public static $debug = FALSE;
    public static $primary_language = FALSE;
    public static $langs_settings = FALSE;
    public static $email = FALSE;
    public static $email_name = FALSE;
    public static $smtp_status = FALSE;
    public static $smtp_auth = FALSE;
    public static $host_email = FALSE;
    public static $username_email = FALSE;
    public static $password_email = FALSE;
    public static $smtp_secure = FALSE;
    public static $smtp_port = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->linesOnPage();
        $this->sessionExprTime();
        $this->debug();
        $this->primaryLanguage();
        $this->email();
        $this->emailName();
        $this->smtpStatus();
        $this->smtpAuth();
        $this->hostEmail();
        $this->usernameEmail();
        $this->passwordEmail();
        $this->smtpSecure();
        $this->smtpPort();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu() {
        HeaderMenu::$menu[HeaderMenu::$menu_market][2] = ['?route=settings', 'bi-gear-fill', lang('title_settings_index'), '', 'false'];
    }

    /**
     * Lines on page
     *
     */
    public function linesOnPage() {
        if (Valid::inPOST('lines_on_page')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET lines_on_page=?", [Valid::inPOST('lines_on_page')]);

            Messages::alert('edit', 'success', lang('action_completed_successfully'));

            self::$lines_on_page = Settings::linesOnPage();
        }
    }

    /**
     * Session Expr Time
     *
     */
    public function sessionExprTime() {
        if (Valid::inPOST('session_expr_time')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET session_expr_time=?", [Valid::inPOST('session_expr_time')]);

            self::$session_expr_time = Settings::sessionExprTime();
        }
    }

    /**
     * Debug
     *
     */
    public function debug() {
        self::$debug = Pdo::getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('debug')) {

            if (Valid::inPOST('debug') == lang('debug_on')) {
                $debug_set = 1;
            }
            if (Valid::inPOST('debug') == lang('debug_off')) {
                $debug_set = 0;
            }

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET debug=?", [$debug_set]);

            self::$debug = Pdo::getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Primary Language
     *
     */
    public function primaryLanguage() {
        self::$primary_language = Settings::primaryLanguage();
        self::$langs_settings = Func::deleteValInArray(lang('#lang_all'), [self::$primary_language]);

        if (Valid::inPOST('primary_language')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [Valid::inPOST('primary_language')]);

            self::$primary_language = Settings::primaryLanguage();
        }
    }

    /**
     * Email
     *
     */
    public function email() {
        self::$email = Pdo::getCell("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('email')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET email=?", [Valid::inPOST('email')]);

            self::$email = Pdo::getCell("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Email Name
     *
     */
    public function emailName() {
        self::$email_name = Pdo::getCell("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('email_name')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET email_name=?", [Valid::inPOST('email_name')]);

            self::$email_name = Pdo::getCell("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Smtp Status
     *
     */
    public function smtpStatus() {
        self::$smtp_status = Pdo::getCell("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('smtp_status')) {
            if (Valid::inPOST('smtp_status') == 'on') {
                $smtp_status_set = 1;
            }
            if (Valid::inPOST('smtp_status') == 'off') {
                $smtp_status_set = 0;
            }

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_status=?", [$smtp_status_set]);

            self::$smtp_status = Pdo::getCell("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Auth
     *
     */
    public function smtpAuth() {
        self::$smtp_auth = Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('smtp_auth')) {

            if (Valid::inPOST('smtp_auth') == lang('debug_on')) {
                $smtp_auth_set = 1;
            }
            if (Valid::inPOST('smtp_auth') == lang('debug_off')) {
                $smtp_auth_set = 0;
            }

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_auth=?", [$smtp_auth_set]);

            self::$smtp_auth = Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
        self::$smtp_auth = Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
    }

    /**
     * Host
     *
     */
    public function hostEmail() {
        self::$host_email = Pdo::getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('host_email')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET host_email=?", [Valid::inPOST('host_email')]);

            self::$host_email = Pdo::getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Username
     *
     */
    public function usernameEmail() {
        self::$username_email = Pdo::getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('username_email')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET username_email=?", [Valid::inPOST('username_email')]);

            self::$username_email = Pdo::getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Password
     *
     */
    public function passwordEmail() {
        self::$password_email = Pdo::getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('password_email')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET password_email=?", [Valid::inPOST('password_email')]);

            self::$password_email = Pdo::getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Secure
     *
     */
    public function smtpSecure() {
        self::$smtp_secure = Pdo::getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('smtp_secure')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_secure=?", [Valid::inPOST('smtp_secure')]);

            self::$smtp_secure = Pdo::getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Port
     *
     */
    public function smtpPort() {
        self::$smtp_port = Pdo::getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (Valid::inPOST('smtp_port')) {

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_port=?", [Valid::inPOST('smtp_port')]);

            self::$smtp_port = Pdo::getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

}
