<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для получения установок, настроек и др.
 *
 * @package Set
 * @author eMarket
 * 
 */
class Set {

    /**
     * Название текущего шаблона
     *
     * @return string $template
     */
    public static function template() {
        $template = 'default';
        return $template;
    }

    /**
     * Данные по валютам
     *
     * @return array $currencies
     */
    public static function currenciesData() {

        $currencies = \eMarket\Pdo::getColRow("SELECT name, id FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);
        return $currencies;
    }

    /**
     * Данные по основной валюте
     *
     * @return array $currency
     */
    public static function currencyDefault() {

        if (!isset($_SESSION['currency_default_catalog'])) {
            $currency = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [lang('#lang_all')[0], 1])[0];
            $_SESSION['currency_default_catalog'] = $currency[0];
        } elseif (isset($_SESSION['currency_default_catalog']) && !\eMarket\Valid::inGET('currency_default')) {
            $currency = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $_SESSION['currency_default_catalog']])[0];
        } elseif (isset($_SESSION['currency_default_catalog']) && \eMarket\Valid::inGET('currency_default')) {
            $currency = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], \eMarket\Valid::inGET('currency_default')])[0];
            $_SESSION['currency_default_catalog'] = $currency[0];
        }

        return $currency;
    }

    /**
     * Каноническая ссылка
     *
     * @return string $path
     */
    public static function canonicalPathCatalog() {

        $path_temp = \eMarket\Valid::inSERVER('REQUEST_URI');
        if (\eMarket\Valid::inSERVER('REQUEST_URI') == '/') {
            $path_temp = '';
        }
        $path = HTTP_SERVER . $path_temp;

        if (strrpos(\eMarket\Valid::inSERVER('REQUEST_URI'), '?route') == true) {
            $path_temp = HTTP_SERVER . str_replace('/?route', '?route', \eMarket\Valid::inSERVER('REQUEST_URI'));
            $path = str_replace('index.php', '', $path_temp);
        }

        return $path;
    }

    /**
     * Текущая ветка (admin или catalog)
     *
     * @return string $path
     */
    public static function path() {

        if (strrpos(\eMarket\Valid::inSERVER('REQUEST_URI'), 'controller/admin/') == true) {
            $path = 'admin';
        } elseif (strrpos(\eMarket\Valid::inSERVER('REQUEST_URI'), 'controller/install/') == true) {
            $path = 'install';
        } else {
            $path = 'catalog';
        }

        return $path;
    }

    /**
     * Текущая директория
     *
     * @return string $title_dir
     */
    public static function titleDir() {

        $title_dir = str_replace('/', '_', \eMarket\Valid::inGET('route'));
        if (\eMarket\Valid::inGET('route_file') != '') {
            $title_dir = $title_dir . '_page_' . \eMarket\Valid::inGET('route_file');
        }

        if ($title_dir == '' && self::path() == 'catalog') {
            $title_dir = '';
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
     * Название раздела в каталоге
     *
     * @param string $marker (маркер для указания знака)
     * @return string $title
     */
    public static function titleCatalog($marker = null) {

        if ($marker == 'false') {
            $sign = '';
        }
        if ($marker == null) {
            $sign = ': ';
        }
        $title = $sign . lang('title_' . basename(\eMarket\Valid::inGET('route')) . '_index');

        if (basename(\eMarket\Valid::inGET('route')) == '' && self::path() == 'catalog') {
            $title = '';
        }

        if (basename(\eMarket\Valid::inGET('route')) == 'listing' && self::path() == 'catalog') {
            $title = $sign . \eMarket\Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], \eMarket\Valid::inGET('category_id')]);
        }

        if (basename(\eMarket\Valid::inGET('route')) == 'products' && self::path() == 'catalog') {
            $title = $sign . \eMarket\Pdo::getCell("SELECT name FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], \eMarket\Valid::inGET('id')]);
        }

        return $title;
    }

    /**
     * Считываем значение строк на странице
     *
     * @return string $lines_on_page
     */
    public static function linesOnPage() {

        $lines_on_page = \eMarket\Pdo::selectPrepare("SELECT lines_on_page FROM " . TABLE_BASIC_SETTINGS, []);
        return $lines_on_page;
    }

    /**
     * Считываем значение времени сессии администратора
     *
     * @return string $session_expr_time
     */
    public static function sessionExprTime() {

        $session_expr_time = \eMarket\Pdo::selectPrepare("SELECT session_expr_time FROM " . TABLE_BASIC_SETTINGS, []);
        return $session_expr_time;
    }

    /**
     * Отображаем Select с учетом значения по-умолчанию
     *
     * @param array $value (массив для Select)
     * @param string $id (идентификатор id)
     * @param string (если не нужно Selected, то указываем FALSE)
     */
    public static function viewSelect($value, $id = null, $selected = null) {

        $count_value = count($value);
        for ($x = 0; $x < $count_value; $x++) {
            if (isset($value[$x][1]) && $value[$x][1] == 1 && $selected != FALSE && $id != null) {
                ?>
                <!-- Строка Select по умолчанию-->
                <option value="<?php echo $id ?>" selected><?php echo $value[$x][0] ?></option>
            <?php } else { ?>
                <option><?php echo $value[$x][0] ?></option>
                <?php
            }
        }
    }

    /**
     * IP адрес пользователя
     *
     * @return string $ipaddress
     */
    public static function ipAdress() {

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
     * Получаем названия для Breadcrumb
     *
     * @param array $breadcrumb_array (массив breadcrumb в виде id)
     * @return string $breadcrumb (массив breadcrumb в виде названия)
     */
    public static function breadcrumbName($breadcrumb_array) {

        $breadcrumb = [];
        foreach ($breadcrumb_array as $value) {
            $name = \eMarket\Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value]);
            array_push($breadcrumb, $name);
        }

        return $breadcrumb;
    }

    /**
     * Получаем parent_id для Breadcrumb
     *
     * @param array $breadcrumb_array (массив breadcrumb в виде id)
     * @return string $breadcrumb (массив breadcrumb в виде parent_id)
     */
    public static function breadcrumbParentId($breadcrumb_array) {

        $breadcrumb = [];
        foreach ($breadcrumb_array as $value) {
            $name = \eMarket\Pdo::getCell("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value]);
            array_push($breadcrumb, $name);
        }

        return $breadcrumb;
    }

    /**
     * Получаем путь к папке модуля
     *
     * @return string (путь к папке с модулем)
     */
    public static function modulesPath() {

        return ROOT . '/modules/' . \eMarket\Valid::inGET('type') . '/' . \eMarket\Valid::inGET('name');
    }

    /**
     * Получаем название базы данных модуля
     *
     * @return string (название базы данных модуля)
     */
    public static function moduleDatabase() {

        return DB_PREFIX . 'modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name');
    }

    /**
     * Форматированная дата
     *
     * @return string|FALSE форматированная дата
     */
    public static function dateLocale($date, $format = null) {
        if ($format != null) {
            return strftime($format, date('U', strtotime($date)));
        } else {
            return strftime('%x', date('U', strtotime($date)));
        }
        return FALSE;
    }

}
?>