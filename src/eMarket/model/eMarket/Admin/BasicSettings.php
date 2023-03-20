<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Cache,
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
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class BasicSettings {

    public static $routing_parameter = 'settings/basic_settings';
    public $title = 'title_settings_basic_settings_index';
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
    public static $cache_status = FALSE;
    public static $caching_time = FALSE;

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
        $Cache = new Cache();
        self::$cache_status = $Cache->cache_status;
        self::$caching_time = $Cache->caching_time;
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_market][2] = ['?route=settings', 'bi-gear-fill', lang('title_settings_index'), '', 'false'];
    }

    /**
     * Lines on page
     *
     */
    private function linesOnPage(): void {
        if (Valid::inPOST('lines_on_page')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET lines_on_page=?", [Valid::inPOST('lines_on_page')]);
            self::$lines_on_page = Settings::linesOnPage();
            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Session Expr Time
     *
     */
    private function sessionExprTime(): void {
        if (Valid::inPOST('session_expr_time')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET session_expr_time=?", [Valid::inPOST('session_expr_time')]);
            self::$session_expr_time = Settings::sessionExprTime();
        }
    }

    /**
     * Debug
     *
     */
    private function debug(): void {
        self::$debug = Pdo::getValue("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('debug')) {
            $debug_set = 0;

            if (Valid::inPOST('debug') == 'on') {
                $debug_set = 1;
            }

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET debug=?", [$debug_set]);
            self::$debug = Pdo::getValue("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Primary Language
     *
     */
    private function primaryLanguage(): void {
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
    private function email(): void {
        self::$email = Pdo::getValue("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('email')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET email=?", [Valid::inPOST('email')]);
            self::$email = Pdo::getValue("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Email Name
     *
     */
    private function emailName(): void {
        self::$email_name = Pdo::getValue("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('email_name')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET email_name=?", [Valid::inPOST('email_name')]);
            self::$email_name = Pdo::getValue("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Smtp Status
     *
     */
    private function smtpStatus(): void {
        self::$smtp_status = Pdo::getValue("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('smtp_status')) {
            $smtp_status_set = 0;

            if (Valid::inPOST('smtp_status') == 'on') {
                $smtp_status_set = 1;
            }

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_status=?", [$smtp_status_set]);
            self::$smtp_status = Pdo::getValue("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Auth
     *
     */
    private function smtpAuth(): void {
        self::$smtp_auth = Pdo::getValue("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('smtp_auth')) {
            $smtp_auth_set = 0;

            if (Valid::inPOST('smtp_auth') == lang('debug_on')) {
                $smtp_auth_set = 1;
            }

            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_auth=?", [$smtp_auth_set]);
            self::$smtp_auth = Pdo::getValue("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Host
     *
     */
    private function hostEmail(): void {
        self::$host_email = Pdo::getValue("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('host_email')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET host_email=?", [Valid::inPOST('host_email')]);
            self::$host_email = Pdo::getValue("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Username
     *
     */
    private function usernameEmail(): void {
        self::$username_email = Pdo::getValue("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('username_email')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET username_email=?", [Valid::inPOST('username_email')]);
            self::$username_email = Pdo::getValue("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Password
     *
     */
    private function passwordEmail(): void {
        self::$password_email = Pdo::getValue("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('password_email')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET password_email=?", [Valid::inPOST('password_email')]);
            self::$password_email = Pdo::getValue("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Secure
     *
     */
    private function smtpSecure(): void {
        self::$smtp_secure = Pdo::getValue("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('smtp_secure')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_secure=?", [Valid::inPOST('smtp_secure')]);
            self::$smtp_secure = Pdo::getValue("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Port
     *
     */
    private function smtpPort(): void {
        self::$smtp_port = Pdo::getValue("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);

        if (Valid::inPOST('smtp_port')) {
            Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_port=?", [Valid::inPOST('smtp_port')]);
            self::$smtp_port = Pdo::getValue("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

}
