<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use \eMarket\Core\{
    Func,
    Pdo,
    Products,
    Valid,
    View
};

/**
 * Settings
 *
 * @package Set
 * @author eMarket
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

    /**
     * Name of current template
     *
     * @return string $template
     */
    public static function template() {
        $template = 'default';
        return $template;
    }

    /**
     * Loading static data
     *
     * @param string $param DB col
     * @return array|string
     */
    public static function basicSettings($param = null) {

        if (self::$basic_settings == FALSE) {
            self::$basic_settings = Pdo::getColAssoc("SELECT * FROM " . TABLE_BASIC_SETTINGS, [])[0];
        }

        if ($param != null) {
            return self::$basic_settings[$param];
        }

        return self::$basic_settings;
    }

    /**
     * Currencies Data
     *
     * @return array
     */
    public static function currenciesData() {

        if (self::$currencies_data == FALSE) {
            self::$currencies_data = Pdo::getColAssoc("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);
        }

        return self::$currencies_data;
    }

    /**
     * Number of lines on page
     *
     * @return string
     */
    public static function linesOnPage() {

        return self::basicSettings('lines_on_page');
    }

    /**
     * Administrator session time value
     *
     * @return string
     */
    public static function sessionExprTime() {

        return self::basicSettings('session_expr_time');
    }

    /**
     * JS Handler
     *
     * @return string
     */
    public static function jsHandler() {
        if (self::path() == 'admin' OR Settings::path() == 'catalog') {
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
     * @return string
     */
    public static function jsModulesHandler() {
        $path = View::routingModules('js_handler');
        if (file_exists($path . '/js.php')) {
            self::$js_modules_handler = $path;
        }
    }

    /**
     * Tooltip data for product discounts
     *
     * @param string $discount Data on discounts in a line separated by commas
     * @return string
     */
    public static function productSaleTooltip($discount) {

        $discount_json = json_decode($discount, 1);
        $text = '';
        foreach ($discount_json as $key => $id) {
            foreach ($id as $val_id) {
                $text .= lang('modules_discount_' . $key . '_name') . ': ' . Pdo::getCellFalse("SELECT name FROM " . DB_PREFIX . 'modules_discount_' . $key . "  WHERE language=? AND id=?", [lang('#lang_all')[0], $val_id]) . '<br>';
            }
        }

        return $text;
    }

    /**
     * Currency default
     *
     * @param string $language Language
     * @return array
     */
    public static function currencyDefault($language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        } else {
            self::$default_currency = FALSE;
        }

        if (self::$default_currency == FALSE) {

            if (self::path() == 'catalog') {
                if (!isset($_SESSION['currency_default_catalog'])) {
                    $currency = Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [$language, 1])[0];
                    $_SESSION['currency_default_catalog'] = $currency[0];
                } elseif (isset($_SESSION['currency_default_catalog']) && !Valid::inGET('currency_default')) {
                    $currency = Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [$language, $_SESSION['currency_default_catalog']])[0];
                } elseif (isset($_SESSION['currency_default_catalog']) && Valid::inGET('currency_default')) {
                    $currency = Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [$language, Valid::inGET('currency_default')])[0];
                    $_SESSION['currency_default_catalog'] = $currency[0];
                }
            }

            if (self::path() == 'admin') {
                $currency = Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [$language, 1])[0];
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
    public static function canonicalPathCatalog() {

        $path_temp = Valid::inSERVER('REQUEST_URI');
        if (Valid::inSERVER('REQUEST_URI') == '/') {
            $path_temp = '';
        }
        $path = HTTP_SERVER . $path_temp;

        if (strrpos(Valid::inSERVER('REQUEST_URI'), '?route') == true) {
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
    public static function path() {

        if (strrpos(Valid::inSERVER('REQUEST_URI'), 'controller/admin/') == true) {
            $path = 'admin';
        } elseif (strrpos(Valid::inSERVER('REQUEST_URI'), 'controller/install/') == true) {
            $path = 'install';
        } else {
            $path = 'catalog';
        }

        return $path;
    }

    /**
     * Current directory
     *
     * @return string
     */
    public static function titleDir() {

        $title_dir = str_replace('/', '_', Valid::inGET('route'));
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
    public static function titlePageGenerator() {

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
    public static function parentPartitionGenerator() {

        if (Valid::inGET('route') == 'settings/modules/edit' && Valid::inGET('module_path')) {
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

        if (Valid::inGET('route') == 'settings/modules/edit' && !Valid::inGET('module_path')) {
            $output = '?route=settings/modules&active=' . Valid::inGET('type');
            return $output;
        }

        if (Valid::inGET('route')) {
            $input = explode('/', Valid::inGET('route'));
            array_pop($input);
            $output = '?route=' . implode('/', $input);

            return $output;
        }
    }

    /**
     * Section name in catalog
     *
     * @param string $marker Marker
     * @return string
     */
    public static function titleCatalog($marker = null) {

        if ($marker == 'false') {
            $sign = '';
        }
        if ($marker == null) {
            $sign = ': ';
        }
        $title = $sign . lang('title_' . basename(Valid::inGET('route')) . '_index');

        if (basename(Valid::inGET('route')) == '' && self::path() == 'catalog' OR basename(Valid::inGET('route')) == 'catalog' && self::path() == 'catalog') {
            $title = '';
        }

        if (basename(Valid::inGET('route')) == 'listing' && self::path() == 'catalog') {
            $title = $sign . Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], Valid::inGET('category_id')]);
        }

        if (basename(Valid::inGET('route')) == 'products' && self::path() == 'catalog') {
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
     * @return string
     */
    public static function keywordsCatalog() {

        $keywords = '';

        if (basename(Valid::inGET('route')) == 'products' && self::path() == 'catalog') {
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
     * @param string
     */
    public static function viewSelect($value, $default = null) {

        foreach ($value as $val) {
            if ($default != null && $val[$default] == 1) {
                ?>
                <option value="<?php echo $val['id'] ?>" selected><?php echo $val['name'] ?></option>
            <?php } else { ?>
                <option value="<?php echo $val['id'] ?>" ><?php echo $val['name'] ?></option>
                <?php
            }
        }
    }

    /**
     * IP address
     *
     * @return string $ipaddress
     */
    public static function ipAddress() {

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
     * @return string
     */
    public static function breadcrumbName($breadcrumb_array) {

        $breadcrumb = [];
        foreach ($breadcrumb_array as $value) {
            $name = Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value]);
            array_push($breadcrumb, $name);
        }

        return $breadcrumb;
    }

    /**
     * Path to module folder
     *
     * @return string
     */
    public static function modulesPath() {

        return ROOT . '/modules/' . Valid::inGET('type') . '/' . Valid::inGET('name');
    }

    /**
     * Path for language and currency switcher
     *
     * @return string
     */
    public static function langCurrencyPath() {

        if (self::$lang_currency_path != FALSE) {
            return self::$lang_currency_path;
        }

        if (Valid::inSERVER('REQUEST_URI') == '/') {
            self::$lang_currency_path = HTTP_SERVER . '?route=catalog';
        } elseif (Valid::inSERVER('REQUEST_URI') == '/controller/admin/') {
            self::$lang_currency_path = HTTP_SERVER . 'controller/admin/?route=dashboard';
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
    public static function primaryLanguage() {

        return self::basicSettings('primary_language');
    }

    /**
     * Sorting when searching
     *
     * @param string $class Bootstrap class
     * @return string
     */
    public static function sorties($class = null) {

        if ($class != null && Valid::inGET('search')) {
            return $class;
        }

        if ($class == null && !Valid::inGET('search')) {
            return '<td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>';
        }

        if ($class == null && Valid::inGET('search')) {
            return '<td class="sortleft-m"></td> ';
        }
    }

    /**
     * Switching class when changing status
     *
     * @param string $status Status from DB
     * @param array $argument_1 Argument to compare
     * @param array $argument_2 Argument to compare
     * @param string $class Bootstrap class
     * @param string $class_2 Bootstrap class
     * @return string
     */
    public static function statusSwitchClass($status, $argument_1 = null, $argument_2 = null, $class = '', $class_2 = 'danger') {

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
     * Module database name
     *
     * @return string 
     */
    public static function moduleDatabase() {

        return DB_PREFIX . 'modules_' . Valid::inGET('type') . '_' . Valid::inGET('name');
    }

    /**
     * Formatted date
     * 
     * @param string $date Date
     * @param string $format Manual format
     * @param string $language Language
     * @return string|FALSE
     */
    public static function dateLocale($date, $format = null, $language = null) {
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
            $output = strftime($format, date('U', strtotime($date)));
            return $output;
        } else {
            if ($language != null) {
                setlocale(LC_ALL, lang('language_locale', $language));
            }
            if ($language == null) {
                setlocale(LC_ALL, lang('language_locale'));
            }
            $output = strftime('%x', date('U', strtotime($date)));
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
    public static function activeTab($active_tab, $active, $class = 'active') {

        if ($active_tab == $active && self::$active_tabs_count == 0) {
            self::$active_tabs_count = 1;
            return $class;
        } else {
            return '';
        }
    }

}
