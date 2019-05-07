<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

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
    public function template() {
        $template = 'default';
        return $template;
    }

    /**
     * Данные по валютам
     *
     * @return array $currencies
     */
    public function currenciesData() {
        $PDO = new \eMarket\Core\Pdo;

        $currencies = $PDO->getColRow("SELECT name, id FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);
        return $currencies;
    }

    /**
     * Данные по основной валюте
     *
     * @return array $currency
     */
    public function currencyDefault() {
        $PDO = new \eMarket\Core\Pdo;
        $VALID = new \eMarket\Core\Valid;

        if (!isset($_SESSION['currency_default_catalog'])) {
            $currency = $PDO->getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [lang('#lang_all')[0], 1])[0];
            $_SESSION['currency_default_catalog'] = $currency[0];
        } elseif (isset($_SESSION['currency_default_catalog']) && !$VALID->inGET('currency_default')) {
            $currency = $PDO->getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $_SESSION['currency_default_catalog']])[0];
        } elseif (isset($_SESSION['currency_default_catalog']) && $VALID->inGET('currency_default')) {
            $currency = $PDO->getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $VALID->inGET('currency_default')])[0];
            $_SESSION['currency_default_catalog'] = $currency[0];
        }

        return $currency;
    }

    /**
     * Каноническая ссылка
     *
     * @return string $path
     */
    public function canonicalPathCatalog() {
        $VALID = new \eMarket\Core\Valid;

        $path_temp = $VALID->inSERVER('REQUEST_URI');
        if ($VALID->inSERVER('REQUEST_URI') == '/') {
            $path_temp = '';
        }
        $path = HTTP_SERVER . $path_temp;

        if (strrpos($VALID->inSERVER('REQUEST_URI'), '?route') == true) {
            $path_temp = HTTP_SERVER . str_replace('/?route', '?route', $VALID->inSERVER('REQUEST_URI'));
            $path = str_replace('index.php', '', $path_temp);
        }

        return $path;
    }

    /**
     * Текущая ветка (admin или catalog)
     *
     * @return string $path
     */
    public function path() {
        $VALID = new \eMarket\Core\Valid;

        if (strrpos($VALID->inSERVER('REQUEST_URI'), 'controller/admin/') == true) {
            $path = 'admin';
        } elseif (strrpos($VALID->inSERVER('REQUEST_URI'), 'controller/install/') == true) {
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
    public function titleDir() {
        $VALID = new \eMarket\Core\Valid;

        $title_dir = basename($VALID->inGET('route'));
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
     * @return string $title
     */
    public function titleCatalog() {
        $VALID = new \eMarket\Core\Valid;
        $PDO = new \eMarket\Core\Pdo;
        
        $title = lang('title_' . basename($VALID->inGET('route')) . '_index');
        
        if (basename($VALID->inGET('route')) == '' && self::path() == 'catalog') {
            $title = '';
        }
        
        if (basename($VALID->inGET('route')) == 'listing' && self::path() == 'catalog') {
            $title = $PDO->getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $VALID->inGET('category_id')]);
        }
        
        if (basename($VALID->inGET('route')) == 'products' && self::path() == 'catalog') {
            $title = $PDO->getCell("SELECT name FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $VALID->inGET('id')]);
        }
        
        return $title;
    }

    /**
     * Считываем значение строк на странице
     *
     * @return string $lines_on_page
     */
    public function linesOnPage() {
        $PDO = new \eMarket\Core\Pdo;
        $lines_on_page = $PDO->selectPrepare("SELECT lines_on_page FROM " . TABLE_BASIC_SETTINGS, []);
        return $lines_on_page;
    }

    /**
     * Считываем значение времени сессии администратора
     *
     * @return string $session_expr_time
     */
    public function sessionExprTime() {
        $PDO = new \eMarket\Core\Pdo;
        $session_expr_time = $PDO->selectPrepare("SELECT session_expr_time FROM " . TABLE_BASIC_SETTINGS, []);
        return $session_expr_time;
    }

    /**
     * Отображаем Select с учетом значения по-умолчанию
     *
     * @param array $value (массив для Select)
     * @param string $id (идентификатор id)
     * @param string (если не нужно Selected, то указываем FALSE)
     */
    public function viewSelect($value, $id = null, $selected = null) {

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
    public function ipAdress() {
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
    public function breadcrumbName($breadcrumb_array) {
        $PDO = new \eMarket\Core\Pdo;
        
        $breadcrumb = [];
        foreach ($breadcrumb_array as $value) {
            $name = $PDO->getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value]);
            array_push ($breadcrumb, $name);
        }

        return $breadcrumb;
    }    
    
    /**
     * Получаем parent_id для Breadcrumb
     *
     * @param array $breadcrumb_array (массив breadcrumb в виде id)
     * @return string $breadcrumb (массив breadcrumb в виде parent_id)
     */
    public function breadcrumbParentId($breadcrumb_array) {
        $PDO = new \eMarket\Core\Pdo;
        
        $breadcrumb = [];
        foreach ($breadcrumb_array as $value) {
            $name = $PDO->getCell("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value]);
            array_push ($breadcrumb, $name);
        }

        return $breadcrumb;
    }      

}

?>