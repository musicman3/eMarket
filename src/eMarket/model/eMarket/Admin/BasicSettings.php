<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Cache,
    Messages,
    Settings,
    Valid
};
use eMarket\Admin\HeaderMenu;
use Cruder\Db;

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

    public static $routing_parameter = 'basic_settings';
    public $title = 'title_basic_settings_index';
    public static $lines_on_page = FALSE;
    public static $session_expr_time = FALSE;
    public static $debug = FALSE;
    public static $primary_language = FALSE;
    public static $template = FALSE;
    public static $templates = FALSE;
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
    public static $store_name = 'eMarket Online Store';
    public static $year_of_foundation = '2018';

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->linesOnPage();
        $this->sessionExprTime();
        $this->debug();
        $this->primaryLanguage();
        $this->templatesList();
        $this->template();
        $this->email();
        $this->emailName();
        $this->smtpStatus();
        $this->smtpAuth();
        $this->hostEmail();
        $this->usernameEmail();
        $this->passwordEmail();
        $this->smtpSecure();
        $this->smtpPort();
        $this->update();
        $this->logo();
        $this->storeName();
        $this->yearOfFoundation();
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
        HeaderMenu::$menu[HeaderMenu::$menu_market][2] = ['?route=basic_settings', 'bi-gear-fill', lang('title_basic_settings_index'), '', 'false'];
    }

    /**
     * Lines on page
     *
     */
    private function linesOnPage(): void {
        if (Valid::inPOST('lines_on_page')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('lines_on_page', Valid::inPOST('lines_on_page'))
                    ->save();

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

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('session_expr_time', Valid::inPOST('session_expr_time'))
                    ->save();

            self::$session_expr_time = Settings::adminSessionTime();
        }
    }

    /**
     * Debug
     *
     */
    private function debug(): void {

        self::$debug = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('debug')
                ->save();

        if (Valid::inPOST('debug')) {
            $debug_set = 0;

            if (Valid::inPOST('debug') == 'on') {
                $debug_set = 1;
            }

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('debug', $debug_set)
                    ->save();

            self::$debug = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('debug')
                    ->save();
        }
    }

    /**
     * Primary Language
     *
     */
    private function primaryLanguage(): void {
        self::$primary_language = Settings::primaryLanguage();

        if (Valid::inPOST('primary_language')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('primary_language', Valid::inPOST('primary_language'))
                    ->save();

            self::$primary_language = Settings::primaryLanguage();
        }
    }

    /**
     * Templates list
     *
     * @return array
     */
    private function templatesList(): array {
        self::$templates = scandir(getenv('DOCUMENT_ROOT') . '/view/');
        unset(self::$templates[0]);
        unset(self::$templates[1]);

        return self::$templates;
    }

    /**
     * Default Template
     *
     */
    private function template(): void {
        self::$template = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('template')
                ->save();

        if (Valid::inPOST('default_template')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('template', Valid::inPOST('default_template'))
                    ->save();

            self::$template = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('template')
                    ->save();
        }
    }

    /**
     * Email
     *
     */
    private function email(): void {

        self::$email = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('email')
                ->save();

        if (Valid::inPOST('email')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('email', Valid::inPOST('email'))
                    ->save();

            self::$email = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('email')
                    ->save();

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Email Name
     *
     */
    private function emailName(): void {

        self::$email_name = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('email_name')
                ->save();

        if (Valid::inPOST('email_name')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('email_name', Valid::inPOST('email_name'))
                    ->save();

            self::$email_name = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('email_name')
                    ->save();
        }
    }

    /**
     * Smtp Status
     *
     */
    private function smtpStatus(): void {

        self::$smtp_status = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('smtp_status')
                ->save();

        if (Valid::inPOST('smtp_status')) {
            $smtp_status_set = 0;

            if (Valid::inPOST('smtp_status') == 'on') {
                $smtp_status_set = 1;
            }

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('smtp_status', $smtp_status_set)
                    ->save();

            self::$smtp_status = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('smtp_status')
                    ->save();
        }
    }

    /**
     * SMTP Auth
     *
     */
    private function smtpAuth(): void {

        self::$smtp_auth = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('smtp_auth')
                ->save();

        if (Valid::inPOST('smtp_auth')) {
            $smtp_auth_set = 0;

            if (Valid::inPOST('smtp_auth') == 'on') {
                $smtp_auth_set = 1;
            }

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('smtp_auth', $smtp_auth_set)
                    ->save();

            self::$smtp_auth = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('smtp_auth')
                    ->save();
        }
    }

    /**
     * Host
     *
     */
    private function hostEmail(): void {

        self::$host_email = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('host_email')
                ->save();

        if (Valid::inPOST('host_email')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('host_email', Valid::inPOST('host_email'))
                    ->save();

            self::$host_email = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('host_email')
                    ->save();
        }
    }

    /**
     * Username
     *
     */
    private function usernameEmail(): void {

        self::$username_email = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('username_email')
                ->save();

        if (Valid::inPOST('username_email')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('username_email', Valid::inPOST('username_email'))
                    ->save();

            self::$username_email = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('username_email')
                    ->save();
        }
    }

    /**
     * Password
     *
     */
    private function passwordEmail(): void {

        self::$password_email = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('password_email')
                ->save();

        if (Valid::inPOST('password_email')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('password_email', Valid::inPOST('password_email'))
                    ->save();

            self::$password_email = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('password_email')
                    ->save();
        }
    }

    /**
     * SMTP Secure
     *
     */
    private function smtpSecure(): void {

        self::$smtp_secure = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('smtp_secure')
                ->save();

        if (Valid::inPOST('smtp_secure')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('smtp_secure', Valid::inPOST('smtp_secure'))
                    ->save();

            self::$smtp_secure = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('smtp_secure')
                    ->save();
        }
    }

    /**
     * SMTP Port
     *
     */
    private function smtpPort(): void {

        self::$smtp_port = Db::connect()
                ->read(TABLE_BASIC_SETTINGS)
                ->selectValue('smtp_port')
                ->save();

        if (Valid::inPOST('smtp_port')) {

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('smtp_port', Valid::inPOST('smtp_port'))
                    ->save();

            self::$smtp_port = Db::connect()
                    ->read(TABLE_BASIC_SETTINGS)
                    ->selectValue('smtp_port')
                    ->save();
        }
    }

    /**
     * Logo update
     *
     */
    private function logo(): void {
        if (Valid::inPostJson('image_data')) {
            if (is_file(getenv('DOCUMENT_ROOT') . '/uploads/temp/files/' . Valid::inPostJson('image_data'))) {

                if (Valid::inPostJson('logo_for') == 'fileupload') {
                    $file = 'admin_logo.png';
                }
                if (Valid::inPostJson('logo_for') == 'fileupload-product') {
                    $file = 'catalog_logo.png';
                }
                copy(getenv('DOCUMENT_ROOT') . '/uploads/temp/files/' . Valid::inPostJson('image_data'), getenv('DOCUMENT_ROOT') . '/uploads/images/emarket_logo/' . $file);
                unlink(getenv('DOCUMENT_ROOT') . '/uploads/temp/files/' . Valid::inPostJson('image_data'));
            }
        }
    }

    /**
     * Update
     *
     */
    private function update(): void {
        if (is_file(getenv('DOCUMENT_ROOT') . '/update.php')) {
            unlink(getenv('DOCUMENT_ROOT') . '/update.php');
        }
    }

    /**
     * Store Name
     *
     */
    private function storeName(): void {

        $other = json_decode(Db::connect()
                        ->read(TABLE_BASIC_SETTINGS)
                        ->selectValue('other')
                        ->save(), true);

        if (isset($other['store_name'])) {
            self::$store_name = $other['store_name'];
        }

        if (Valid::inPOST('store_name')) {

            $other['store_name'] = Valid::inPOST('store_name');
            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('other', json_encode($other))
                    ->save();

            self::$store_name = Valid::inPOST('store_name');

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Year of foundation
     *
     */
    private function yearOfFoundation(): void {

        $other = json_decode(Db::connect()
                        ->read(TABLE_BASIC_SETTINGS)
                        ->selectValue('other')
                        ->save(), true);

        if (isset($other['year_of_foundation'])) {
            self::$year_of_foundation = $other['year_of_foundation'];
        }

        if (Valid::inPOST('year_of_foundation')) {

            $other['year_of_foundation'] = Valid::inPOST('year_of_foundation');
            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('other', json_encode($other))
                    ->save();

            self::$year_of_foundation = Valid::inPOST('year_of_foundation');

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }
}
