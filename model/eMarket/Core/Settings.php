<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Func,
    Pdo,
    Products,
    Valid,
    View
};

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

    private static $default_currency = FALSE;
    private static $active_tabs_count = 0;
    private static $lang_currency_path = FALSE;
    public static $basic_settings = FALSE;
    public static $currencies_data = FALSE;
    public static $js_handler = FALSE;
    public static $js_modules_handler = FALSE;
    public static $session_expr_time = FALSE;
    public static $path = FALSE;

    /**
     * Name of current template
     *
     * @return string $template
     */
    public static function template(): string {
        $template = 'default';
        return $template;
    }

    /**
     * Loading static data
     *
     * @param mixed $param DB col
     * @return mixed
     */
    public static function basicSettings(mixed $param = null): mixed {

        if (self::$basic_settings == FALSE) {
            self::$basic_settings = Pdo::getAssoc("SELECT * FROM " . TABLE_BASIC_SETTINGS, [])[0];
        }

        if ($param != null) {
            return self::$basic_settings[$param];
        }

        return self::$basic_settings;
    }

    /**
     * Currencies Data
     *
     * @return mixed
     */
    public static function currenciesData(): mixed {

        if (self::$currencies_data == FALSE) {
            self::$currencies_data = Pdo::getAssoc("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);
        }

        return self::$currencies_data;
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
    public static function sessionExprTime(): int {

        return (int) self::basicSettings('session_expr_time');
    }

    /**
     * JS Handler
     *
     */
    public static function jsHandler(): void {
        if (self::path() == 'admin') {
            if (Valid::inGET('route')) {
                $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . self::path() . '/pages/' . Valid::inGET('route');
            } else {
                $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . self::path() . '/pages/dashboard';
            }
            if (file_exists($path . '/js.php')) {
                self::$js_handler = $path;
            }
        }

        if (Settings::path() == 'catalog') {
            $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . self::path() . '/pages/' . Valid::inGET('route');
            if (file_exists($path . '/js.php')) {
                self::$js_handler = $path;
            }
        }

        if (self::path() == 'install') {
            $path = getenv('DOCUMENT_ROOT') . '/js_handler/' . self::path() . Valid::inGET('route');
            if (file_exists($path . '/js.php')) {
                self::$js_handler = $path;
            }
        }
    }

    /**
     * JS Modules Handler
     *
     * @param string $js_path Path to js.php
     */
    public static function jsModulesHandler(?string $js_path = null): void {
        if (self::path() == 'admin') {
            $path = View::routingModules('js_handler');
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }
        if (self::path() == 'catalog' && $js_path == null) {
            $path = ROOT . '/modules/payment/' . Valid::inPOST('payment_method') . '/js_handler/catalog';
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }
        if (self::path() == 'catalog' && $js_path != null) {
            $path = ROOT . '/modules/' . $js_path . '/js_handler/catalog';
            if (file_exists($path . '/js.php')) {
                self::$js_modules_handler = $path;
            }
        }
    }

    /**
     * Currency default
     *
     * @param string $language Language
     * @return array
     */
    public static function currencyDefault(?string $language = null): mixed {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        } else {
            self::$default_currency = FALSE;
        }

        if (self::$default_currency == FALSE) {

            if (self::path() == 'catalog') {
                if (!isset($_SESSION['currency_default_catalog'])) {
                    $currency = Pdo::getIndex("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [$language, 1])[0];
                    $_SESSION['currency_default_catalog'] = $currency[0];
                } elseif (isset($_SESSION['currency_default_catalog']) && !Valid::inGET('currency_default')) {
                    $currency = Pdo::getIndex("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [$language, $_SESSION['currency_default_catalog']])[0];
                } elseif (isset($_SESSION['currency_default_catalog']) && Valid::inGET('currency_default')) {
                    $currency = Pdo::getIndex("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [$language, Valid::inGET('currency_default')])[0];
                    $_SESSION['currency_default_catalog'] = $currency[0];
                }
            }

            if (self::path() == 'admin') {
                $currency = Pdo::getIndex("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [$language, 1])[0];
            }

            self::$default_currency = $currency;

            if ($language != null) {
                self::$default_currency = FALSE;
            }

            return $currency;
        } else {
            return self::$default_currency;
        }
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
     * Current branch (admin/catalog/install)
     *
     * @return string
     */
    public static function path(): string {

        if (self::$path == FALSE) {
            if (strrpos(Valid::inSERVER('REQUEST_URI'), 'controller/admin/')) {
                self::$path = 'admin';
            } elseif (strrpos(Valid::inSERVER('REQUEST_URI'), 'controller/install/')) {
                self::$path = 'install';
            } else {
                self::$path = 'catalog';
            }
        }

        return self::$path;
    }

    /**
     * Current directory
     *
     * @return mixed
     */
    public static function titleDir(): mixed {

        $route = Valid::inGET('route');

        if (is_bool($route) || is_null($route)) {
            $route = '';
        }

        $title_dir = str_replace('/', '_', $route);
        if (Valid::inGET('route_file') != '') {
            $title_dir = $title_dir . '_page_' . Valid::inGET('route_file');
        }

        if ($title_dir == '' && self::path() == 'catalog') {
            $title_dir = 'catalog';
        }
        if ($title_dir == '' && self::path() == 'admin') {
            $title_dir = 'dashboard';
        }
        if ($title_dir == '' && self::path() == 'install') {
            $title_dir = 'install';
        }
        return $title_dir;
    }

    /**
     * Tittles generator
     *
     * @return string
     */
    public static function titlePageGenerator(): string {

        if (self::path() == 'install') {
            $title = lang('title_' . self::titleDir() . '_' . basename(Valid::inSERVER('PHP_SELF'), '.php'));
            return $title;
        }

        if (Valid::inGET('route') == 'settings/modules/edit') {
            $title = lang('modules_' . Valid::inGET('type') . '_' . Valid::inGET('name') . '_name');
            return $title;
        }
        $title = lang('title_' . self::titleDir() . '_index');

        return $title;
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

        if ($route == 'settings/modules/edit' && Valid::inGET('module_path')) {
            $input = explode('/', Valid::inGET('module_path'));
            array_pop($input);
            $module_path = implode('/', $input);

            if ($module_path != '') {
                $output = '?route=settings/modules/edit&type=' . Valid::inGET('type') . '&name=' . Valid::inGET('name') . '&module_path=' . $module_path;
                return $output;
            } else {
                $output = '?route=settings/modules/edit&type=' . Valid::inGET('type') . '&name=' . Valid::inGET('name');
                return $output;
            }
        }

        if ($route == 'settings/modules/edit' && !Valid::inGET('module_path')) {
            $output = '?route=settings/modules&active=' . Valid::inGET('type');
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
     * Section name in catalog
     *
     * @param string $marker Marker
     * @return mixed
     */
    public static function titleCatalog(?string $marker = null): mixed {

        if ($marker == 'false') {
            $sign = '';
        }
        if ($marker == null) {
            $sign = ': ';
        }

        $route = Valid::inGET('route');

        if (is_bool($route) || is_null($route)) {
            $route = '';
        }

        $title = $sign . lang('title_' . basename($route) . '_index');

        if (basename($route) == '' && self::path() == 'catalog' OR basename($route) == 'catalog' && self::path() == 'catalog') {
            $title = '';
        }

        if (basename($route) == 'listing' && self::path() == 'catalog') {
            $title = $sign . Pdo::getValue("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], Valid::inGET('category_id')]);
        }

        if (basename($route) == 'products' && self::path() == 'catalog') {
            $product_data = Products::productData(Valid::inGET('id'));
            if ($product_data ['tags'] != NULL && $product_data ['tags'] != '') {
                $title = $sign . $product_data ['tags'];
            } else {
                $title = $sign . $product_data ['name'];
            }
        }

        return lang('title_catalog_index') . $title;
    }

    /**
     * Keywords
     *
     * @return mixed
     */
    public static function keywordsCatalog(): mixed {

        $keywords = '';
        $route = Valid::inGET('route');

        if (is_bool($route) || is_null($route)) {
            $route = '';
        }

        if (basename($route) == 'products' && self::path() == 'catalog') {
            $product_data = Products::productData(Valid::inGET('id'));
            if ($product_data ['keyword'] != NULL && $product_data ['keyword'] != '') {
                $keywords = $product_data ['keyword'];
            } else {
                $keywords = '';
            }
        }

        return $keywords;
    }

    /**
     * Select view
     *
     * @param array $value Select array
     * @param string|int $default Default sell name
     * @param string|bool
     */
    public static function viewSelect(array $value, string|int $default): string|bool {

        if ($value[$default] == 1) {
            return 'selected';
        }
        return false;
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
     * Breadcrumb data
     *
     * @param array $breadcrumb_array Input array
     * @return array
     */
    public static function breadcrumbName(array $breadcrumb_array): array {

        $breadcrumb = [];
        foreach ($breadcrumb_array as $value) {
            $name = Pdo::getValue("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value]);
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
        } elseif (Valid::inSERVER('REQUEST_URI') == '/controller/admin/') {
            self::$lang_currency_path = HTTP_SERVER . 'controller/admin/?route=dashboard';
        } elseif (Valid::inSERVER('REQUEST_URI') == '/?route=checkout') {
            self::$lang_currency_path = HTTP_SERVER . '?route=cart';
        } else {
            self::$lang_currency_path = Valid::inSERVER('REQUEST_URI');
        }

        if (Valid::inGET('language')) {
            self::$lang_currency_path = Func::deleteGet('language');
        }

        if (Valid::inGET('currency_default')) {
            self::$lang_currency_path = Func::deleteGet('currency_default');
        }

        return self::$lang_currency_path;
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
     * Class for sorties
     *
     * @param string $class Bootstrap class
     * @return string
     */
    public static function sortiesClass(string $class): string {

        if (Valid::inGET('search')) {
            return $class;
        }
    }

    /**
     * Switching class when changing status
     *
     * @param int|string $status Status from DB
     * @param mixed $argument_1 Argument to compare
     * @param mixed $argument_2 Argument to compare
     * @param string $class Bootstrap class
     * @param string $class_2 Bootstrap class
     * @return string
     */
    public static function statusSwitchClass(int|string $status, mixed $argument_1 = null, mixed $argument_2 = null, string $class = '', string $class_2 = 'table-danger'): ?string {

        if ($argument_1 == null) {
            $arg_1 = null;
        } elseif ($argument_1 != null && $argument_1[0] >= $argument_1[1]) {
            $arg_1 = 'true';
        } else {
            $arg_1 = 'false';
        }

        if ($argument_2 == null) {
            $arg_2 = null;
        } elseif ($argument_2 != null && $argument_2[0] >= $argument_2[1]) {
            $arg_2 = 'true';
        } else {
            $arg_2 = 'false';
        }

        if ($status == 0 OR $arg_1 == 'false' OR $arg_2 == 'false') {
            return $class_2;
        } else {
            return $class;
        }
    }

    /**
     * Formatted date
     * 
     * @param mixed $date Date
     * @param mixed $format Manual format
     * @param string $language Language
     * @return string|bool
     */
    public static function dateLocale(mixed $date, mixed $format = null, ?string $language = null): string|bool {
        if ($date == NULL) {
            return '';
        }

        if ($format != null) {
            if ($language != null) {
                setlocale(LC_ALL, lang('language_locale', $language));
            }
            if ($language == null) {
                setlocale(LC_ALL, lang('language_locale'));
            }
            $output = strftime($format, (int) date('U', strtotime($date)));
            return $output;
        } else {
            if ($language != null) {
                setlocale(LC_ALL, lang('language_locale', $language));
            }
            if ($language == null) {
                setlocale(LC_ALL, lang('language_locale'));
            }
            $output = strftime('%x', (int) date('U', strtotime($date)));
            return $output;
        }

        return FALSE;
    }

    /**
     * Active tab
     *
     * @param string $active_tab Active tab
     * @param string $active Active marker
     * @param string $class Bootstrap class
     * @return string
     */
    public static function activeTab(string $active_tab, string $active, string $class = 'active'): ?string {

        if ($active_tab == $active && self::$active_tabs_count == 0) {
            self::$active_tabs_count = 1;
            return $class;
        } else {
            return '';
        }
    }

}
