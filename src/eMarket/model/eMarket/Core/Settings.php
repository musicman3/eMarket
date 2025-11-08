<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Func,
    Routing
};
use R2D2\R2\Valid;
use Cruder\Db;

/**
 * Settings
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Settings {

    public static $path;
    public static $lang;
    public static $csrf;
    private static $lang_currency_path = FALSE;
    public static $basic_settings = FALSE;
    public static $session_expr_time = FALSE;

    /**
     * Load page object
     *
     */
    public static function init(): void {
        $ini = parse_ini_file(getenv('DOCUMENT_ROOT') . '/storage/configure/settings.cfg', TRUE, INI_SCANNER_RAW);
        self::$path = $ini['path'];
        self::$lang = $ini['lang'];
        self::$csrf = $ini['csrf'];
    }

    /**
     * Current branch (admin/catalog/install)
     *
     * @return string
     */
    public static function path(): string {

        if (!file_exists(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php')) {
            return 'install';
        }

        $pathinfo = pathinfo(Valid::inSERVER('REQUEST_URI'));
        foreach (self::$path as $key => $value) {
            if (strrpos($pathinfo['dirname'], $key) !== false || strrpos($pathinfo['basename'], $key) !== false) {
                return $value;
            }
        }

        return 'catalog';
    }

    /**
     * Name of current template
     *
     * @return string $template
     */
    public static function template(): string {

        if (self::path() == 'install') {
            return 'default';
        }

        return self::basicSettings('template');
    }

    /**
     * Loading static data
     *
     * @param mixed $param DB col
     * @return mixed
     */
    public static function basicSettings(mixed $param = null): mixed {

        if (self::$basic_settings == FALSE) {

            self::$basic_settings = Db::connect()
                            ->read(TABLE_BASIC_SETTINGS)
                            ->selectAssoc('*')
                            ->save()[0];
        }

        if ($param != null) {
            return self::$basic_settings[$param];
        }

        return self::$basic_settings;
    }

    /**
     * Number of lines on page
     *
     * @return int
     */
    public static function linesOnPage(): int {

        return (int) self::basicSettings('lines_on_page');
    }

    /**
     * Administrator session time value
     *
     * @return int
     */
    public static function adminSessionTime(): int {

        return (int) self::basicSettings('session_expr_time');
    }

    /**
     * Primary language
     *
     * @return string
     */
    public static function primaryLanguage(): string {

        return self::basicSettings('primary_language');
    }

    /**
     * Canonical Path
     *
     * @return string
     */
    public static function canonicalPathCatalog(): string {

        $path_temp = Valid::inSERVER('REQUEST_URI');
        if (Valid::inSERVER('REQUEST_URI') == '/') {
            $path_temp = '';
        }
        $path = HTTP_SERVER . $path_temp;

        if (strrpos(Valid::inSERVER('REQUEST_URI'), '?route')) {
            $path_temp = HTTP_SERVER . str_replace('/?route', '?route', Valid::inSERVER('REQUEST_URI'));
            $path = str_replace('index.php', '', $path_temp);
        }

        return $path;
    }

    /**
     * Titles generator
     *
     * @return string
     */
    public static function titlePageGenerator(): string {

        $eMarket = Routing::$eMarket;

        if (isset($eMarket->title)) {
            return lang($eMarket->title);
        }
        return '';
    }

    /**
     * Parent section path generator
     *
     * @return string
     */
    public static function parentPartitionGenerator(): string {

        $route = Valid::inGET('route');

        if (is_bool($route) || is_null($route)) {
            $route = '';
        }

        if ($route == 'modules/edit' && Valid::inGET('module_path')) {
            $input = explode('/', Valid::inGET('module_path'));
            array_pop($input);
            $module_path = implode('/', $input);

            if ($module_path != '') {
                $output = '?route=modules/edit&type=' . Valid::inGET('type') . '&name=' . Valid::inGET('name') . '&module_path=' . $module_path;
                return $output;
            } else {
                $output = '?route=modules/edit&type=' . Valid::inGET('type') . '&name=' . Valid::inGET('name');
                return $output;
            }
        }

        if ($route == 'modules/edit' && !Valid::inGET('module_path')) {
            $output = '?route=modules&active=' . Valid::inGET('type');
            return $output;
        }

        if ($route != '') {
            $input = explode('/', $route);
            array_pop($input);
            $output = '?route=' . implode('/', $input);

            return $output;
        }
    }

    /**
     * Breadcrumb data
     *
     * @param array $breadcrumb_array Input array
     * @return array
     */
    public static function breadcrumbName(array $breadcrumb_array): array {

        $breadcrumb = [];
        foreach ($breadcrumb_array as $value) {

            $name = Db::connect()
                    ->read(TABLE_CATEGORIES)
                    ->selectValue('name')
                    ->where('language=', lang('#lang_all')[0])
                    ->and('id=', $value)
                    ->save();

            array_push($breadcrumb, $name);
        }

        return $breadcrumb;
    }

    /**
     * Path for language and currency switcher
     *
     * @return string
     */
    public static function langCurrencyPath(): string {

        if (self::$lang_currency_path != FALSE) {
            return self::$lang_currency_path;
        }

        if (Valid::inSERVER('REQUEST_URI') == '/') {
            self::$lang_currency_path = HTTP_SERVER . '?route=catalog';
        } elseif (Valid::inSERVER('REQUEST_URI') == '/admin/') {
            self::$lang_currency_path = HTTP_SERVER . 'admin/?route=' . self::defaultPage();
        } elseif (Valid::inSERVER('REQUEST_URI') == '/?route=checkout') {
            self::$lang_currency_path = HTTP_SERVER . '?route=cart';
        } else {
            self::$lang_currency_path = Valid::inSERVER('REQUEST_URI');
        }

        if (Valid::inGET('language')) {
            self::$lang_currency_path = '?' . Func::deleteGet(Valid::inSERVER('QUERY_STRING'), 'language');
        }

        if (Valid::inGET('currency_default')) {
            self::$lang_currency_path = '?' . Func::deleteGet(Valid::inSERVER('QUERY_STRING'), 'currency_default');
        }

        return self::$lang_currency_path;
    }

    /**
     * IP address
     *
     * @return string $ipaddress
     */
    public static function ipAddress(): string {

        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } elseif (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    /**
     * Custom CSS
     *
     */
    public static function customCss(): void {
        if (is_file(getenv('DOCUMENT_ROOT') . '/custom/view/' . self::template() . '/' . self::path() . '/custom.css')) {
            echo '<link rel="stylesheet" type="text/css" href="/custom/view/' . self::template() . '/' . self::path() . '/custom.css" media="screen" />';
        }
    }

    /**
     * Show Catalog button
     *
     * @return string checked
     */
    public static function catalogButton(): string {

        $other = json_decode(self::basicSettings('other'), true);

        if (isset($other['catalog_button']) && $other['catalog_button'] == 'on') {
            return 'on';
        }
        return 'off';
    }
}
