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

    public static $CURRENCIES = FALSE;
    public static $primary_language = FALSE;
    public static $lines_on_page = FALSE;
    public static $session_expr_time = FALSE;

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
     * Данные по тултипу для скидки на товар
     *
     * @param string $discount (данные по скидкам в строке через запятую)
     * @return string $text
     */
    public static function productSaleTooltip($discount) {

        $discount_str_explode_temp = explode(',', $discount);
        $discount_str_explode = \eMarket\Func::deleteEmptyInArray($discount_str_explode_temp);
        $text = '';
        foreach ($discount_str_explode as $id) {
            $text .= \eMarket\Pdo::getCell("SELECT name FROM " . DB_PREFIX . 'modules_discount_sale' . "  WHERE language=? AND id=?", [lang('#lang_all')[0], $id]) . '<br>';
        }

        return $text;
    }

    /**
     * Данные по основной валюте
     *
     * @param string $language (язык)
     * @return array $currency
     */
    public static function currencyDefault($language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        } else {
            self::$CURRENCIES = FALSE;
        }

        if (self::$CURRENCIES == FALSE) {

            if (!isset($_SESSION['currency_default_catalog'])) {
                $currency = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [$language, 1])[0];
                $_SESSION['currency_default_catalog'] = $currency[0];
            } elseif (isset($_SESSION['currency_default_catalog']) && !\eMarket\Valid::inGET('currency_default')) {
                $currency = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [$language, $_SESSION['currency_default_catalog']])[0];
            } elseif (isset($_SESSION['currency_default_catalog']) && \eMarket\Valid::inGET('currency_default')) {
                $currency = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [$language, \eMarket\Valid::inGET('currency_default')])[0];
                $_SESSION['currency_default_catalog'] = $currency[0];
            }

            self::$CURRENCIES = $currency;

            if ($language != null) {
                self::$CURRENCIES = FALSE;
            }

            return $currency;
        } else {
            return self::$CURRENCIES;
        }
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
     * Генератор титлов
     *
     * @return string $title
     */
    public static function titlePageGenerator() {

        if (self::path() == 'install') {
            $title = lang('title_' . \eMarket\Set::titleDir() . '_' . basename(\eMarket\Valid::inSERVER('PHP_SELF'), '.php'));
            return $title;
        }

        if (\eMarket\Valid::inGET('route') == 'settings/modules/edit') {
            $title = lang('modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') . '_name');
            return $title;
        }
        $title = lang('title_' . \eMarket\Set::titleDir() . '_index');

        return $title;
    }

    /**
     * Генератор путей родительских разделов
     *
     * @return string $output
     */
    public static function parentPartitionGenerator() {

        if (\eMarket\Valid::inGET('route') == 'settings/modules/edit' && \eMarket\Valid::inGET('module_path')) {
            $input = explode('/', \eMarket\Valid::inGET('module_path'));
            array_pop($input);
            $module_path = implode('/', $input);

            if ($module_path != '') {
                $output = '?route=settings/modules/edit&type=' . \eMarket\Valid::inGET('type') . '&name=' . \eMarket\Valid::inGET('name') . '&module_path=' . $module_path;
                return $output;
            } else {
                $output = '?route=settings/modules/edit&type=' . \eMarket\Valid::inGET('type') . '&name=' . \eMarket\Valid::inGET('name');
                return $output;
            }
        }

        if (\eMarket\Valid::inGET('route') == 'settings/modules/edit' && !\eMarket\Valid::inGET('module_path')) {
            $output = '?route=settings/modules&active=' . \eMarket\Valid::inGET('type');
            return $output;
        }

        if (\eMarket\Valid::inGET('route')) {
            $input = explode('/', \eMarket\Valid::inGET('route'));
            array_pop($input);
            $output = '?route=' . implode('/', $input);

            return $output;
        }
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

        if (basename(\eMarket\Valid::inGET('route')) == '' && self::path() == 'catalog' OR basename(\eMarket\Valid::inGET('route')) == 'catalog' && self::path() == 'catalog') {
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

        if (self::$lines_on_page == FALSE) {
            self::$lines_on_page = \eMarket\Pdo::selectPrepare("SELECT lines_on_page FROM " . TABLE_BASIC_SETTINGS, []);
        }

        return self::$lines_on_page;
    }

    /**
     * Считываем значение времени сессии администратора
     *
     * @return string $session_expr_time
     */
    public static function sessionExprTime() {

        if (self::$session_expr_time == FALSE) {
            self::$session_expr_time = \eMarket\Pdo::selectPrepare("SELECT session_expr_time FROM " . TABLE_BASIC_SETTINGS, []);
        }

        return self::$session_expr_time;
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
     * Получаем путь к папке модуля
     *
     * @return string (путь к папке с модулем)
     */
    public static function modulesPath() {

        return ROOT . '/modules/' . \eMarket\Valid::inGET('type') . '/' . \eMarket\Valid::inGET('name');
    }

    /**
     * Получаем путь для переключателя языков и валют
     *
     * @return string (путь для переключателя языков и валют)
     */
    public static function langCurrencyPath() {

        if (\eMarket\Valid::inSERVER('REQUEST_URI') == '/') {
            $url_request = HTTP_SERVER . '?route=catalog';
        } elseif (\eMarket\Valid::inSERVER('REQUEST_URI') == '/controller/admin/') {
            $url_request = HTTP_SERVER . 'controller/admin/?route=dashboard';
        } else {
            $url_request = \eMarket\Valid::inSERVER('REQUEST_URI');
        }

        if (\eMarket\Valid::inGET('language')) {
            $url_request = \eMarket\Func::deleteGet('language');
        }

        if (\eMarket\Valid::inGET('currency_default')) {
            $url_request = \eMarket\Func::deleteGet('currency_default');
        }

        return $url_request;
    }

    /**
     * Получаем основной язык
     *
     * @return string (основной язык)
     */
    public static function primaryLanguage() {

        if (self::$primary_language == FALSE) {
            self::$primary_language = \eMarket\Pdo::getCell("SELECT primary_language FROM " . TABLE_BASIC_SETTINGS . "", []);
        }

        return self::$primary_language;
    }

    /**
     * Сортировка при поиске
     *
     * @param string $class (класс bootstrap)
     * @return string (данные html)
     */
    public static function sorties($class = null) {

        if ($class != null && \eMarket\Valid::inGET('search')) {
            return $class;
        }

        if ($class == null && !\eMarket\Valid::inGET('search')) {
            return '<td class="sortyes sortleft-m"><div><span class="glyphicon glyphicon-move"> </span></div></td>';
        }
        
        if ($class == null && \eMarket\Valid::inGET('search')) {
            return '<td class="sortleft-m"></td> ';
        }

    }

    /**
     * Переключение класса при смене статуса
     *
     * @param string $status (статус из БД)
     * @param string $class (класс для переключения)
     * @return string (класс)
     */
    public static function statusSwithClass($status, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }

        if ($status == 0) {
            return $class;
        } else {
            return '';
        }
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
     * @param string $date (дата)
     * @param string $format (формат даты вручную)
     * @param string $language (язык локали)
     * @return string|FALSE форматированная дата
     */
    public static function dateLocale($date, $format = null, $language = null) {
        if ($date == NULL) {
            return '';
        }

        if ($format != null) {
            if ($language != null) {
                setlocale(LC_ALL, lang('language_locale', $language));
            }
            $output = strftime($format, date('U', strtotime($date)));
            if ($language != null) {
                setlocale(LC_ALL, lang('language_locale'));
            }
            return $output;
        } else {
            if ($language != null) {
                setlocale(LC_ALL, lang('language_locale', $language));
            }
            $output = strftime('%x', date('U', strtotime($date)));
            if ($language != null) {
                setlocale(LC_ALL, lang('language_locale'));
            }
            return $output;
        }

        return FALSE;
    }

}
?>