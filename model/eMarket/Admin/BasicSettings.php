<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

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
     * Lines on page
     *
     */
    public function linesOnPage() {
        if (\eMarket\Valid::inPOST('lines_on_page')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET lines_on_page=?", [\eMarket\Valid::inPOST('lines_on_page')]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));

            self::$lines_on_page = \eMarket\Settings::linesOnPage();
        }
    }

    /**
     * Session Expr Time
     *
     */
    public function sessionExprTime() {
        if (\eMarket\Valid::inPOST('session_expr_time')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET session_expr_time=?", [\eMarket\Valid::inPOST('session_expr_time')]);

            self::$session_expr_time = \eMarket\Settings::sessionExprTime();
        }
    }

    /**
     * Debug
     *
     */
    public function debug() {
        self::$debug = \eMarket\Pdo::getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('debug')) {

            if (\eMarket\Valid::inPOST('debug') == lang('debug_on')) {
                $debug_set = 1;
            }
            if (\eMarket\Valid::inPOST('debug') == lang('debug_off')) {
                $debug_set = 0;
            }

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET debug=?", [$debug_set]);

            self::$debug = \eMarket\Pdo::getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Primary Language
     *
     */
    public function primaryLanguage() {
        self::$primary_language = \eMarket\Settings::primaryLanguage();
        self::$langs_settings = \eMarket\Func::deleteValInArray(lang('#lang_all'), [self::$primary_language]);

        if (\eMarket\Valid::inPOST('primary_language')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [\eMarket\Valid::inPOST('primary_language')]);

            self::$primary_language = \eMarket\Settings::primaryLanguage();
        }
    }

    /**
     * Email
     *
     */
    public function email() {
        self::$email = \eMarket\Pdo::getCell("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('email')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET email=?", [\eMarket\Valid::inPOST('email')]);

            self::$email = \eMarket\Pdo::getCell("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Email Name
     *
     */
    public function emailName() {
        self::$email_name = \eMarket\Pdo::getCell("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('email_name')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET email_name=?", [\eMarket\Valid::inPOST('email_name')]);

            self::$email_name = \eMarket\Pdo::getCell("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Smtp Status
     *
     */
    public function smtpStatus() {
        self::$smtp_status = \eMarket\Pdo::getCell("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('smtp_status')) {
            if (\eMarket\Valid::inPOST('smtp_status') == 'on') {
                $smtp_status_set = 1;
            }
            if (\eMarket\Valid::inPOST('smtp_status') == 'off') {
                $smtp_status_set = 0;
            }

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_status=?", [$smtp_status_set]);

            self::$smtp_status = \eMarket\Pdo::getCell("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Auth
     *
     */
    public function smtpAuth() {
        self::$smtp_auth = \eMarket\Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('smtp_auth')) {

            if (\eMarket\Valid::inPOST('smtp_auth') == lang('debug_on')) {
                $smtp_auth_set = 1;
            }
            if (\eMarket\Valid::inPOST('smtp_auth') == lang('debug_off')) {
                $smtp_auth_set = 0;
            }

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_auth=?", [$smtp_auth_set]);

            self::$smtp_auth = \eMarket\Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
        self::$smtp_auth = \eMarket\Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
    }

    /**
     * Host
     *
     */
    public function hostEmail() {
        self::$host_email = \eMarket\Pdo::getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('host_email')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET host_email=?", [\eMarket\Valid::inPOST('host_email')]);

            self::$host_email = \eMarket\Pdo::getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Username
     *
     */
    public function usernameEmail() {
        self::$username_email = \eMarket\Pdo::getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('username_email')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET username_email=?", [\eMarket\Valid::inPOST('username_email')]);

            self::$username_email = \eMarket\Pdo::getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * Password
     *
     */
    public function passwordEmail() {
        self::$password_email = \eMarket\Pdo::getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('password_email')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET password_email=?", [\eMarket\Valid::inPOST('password_email')]);

            self::$password_email = \eMarket\Pdo::getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Secure
     *
     */
    public function smtpSecure() {
        self::$smtp_secure = \eMarket\Pdo::getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('smtp_secure')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_secure=?", [\eMarket\Valid::inPOST('smtp_secure')]);

            self::$smtp_secure = \eMarket\Pdo::getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

    /**
     * SMTP Port
     *
     */
    public function smtpPort() {
        self::$smtp_port = \eMarket\Pdo::getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
        if (\eMarket\Valid::inPOST('smtp_port')) {

            \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_port=?", [\eMarket\Valid::inPOST('smtp_port')]);

            self::$smtp_port = \eMarket\Pdo::getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
        }
    }

}
