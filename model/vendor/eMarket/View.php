<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для шаблонизатора
 *
 * @package View
 * @author eMarket
 * 
 */
class View {

    public static $array_pos_value = null;
    public static $array_pos = null;

    /**
     * Роутинг данных из View
     *
     * @return string $str (роутинг на view)
     */
    public static function routing() {

        $str = str_replace('controller', 'view/' . \eMarket\Settings::template(), getenv('SCRIPT_FILENAME'));

        return $str;
    }

    /**
     * Роутинг данных из View для административной панели
     *
     * @return string $str (роутинг на view)
     */
    public static function routingAdmin() {

        if (\eMarket\Valid::inGET('route_file') != '') {
            $page = \eMarket\Valid::inGET('route_file') . '.php';
        }

        if (!\eMarket\Valid::inGET('route_file') OR \eMarket\Valid::inGET('route_file') == '') {
            $page = 'index.php';
        }

        if (\eMarket\Valid::inGET('route') != '') {
            $str = str_replace('controller', 'view/' . \eMarket\Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Settings::path() . '/pages/' . \eMarket\Valid::inGET('route') . '/' . $page);
        } else {
            $str = str_replace('controller', 'view/' . \eMarket\Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Settings::path() . '/pages/dashboard/index.php');
        }
        if (file_exists($str)) {
            return $str;
        } else {
            return false;
        }
    }

    /**
     * Роутинг данных из View для каталога
     *
     * @return string $str (роутинг на view)
     */
    public static function routingCatalog() {

        if (\eMarket\Valid::inGET('route') != '') {
            $str = str_replace('controller', 'view/' . \eMarket\Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Settings::path() . '/pages/' . \eMarket\Valid::inGET('route') . '/index.php');
        } else {
            $str = str_replace('controller', 'view/' . \eMarket\Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Settings::path() . '/pages/catalog/index.php');
        }
        if (file_exists($str)) {
            return $str;
        } else {
            return false;
        }
    }

    /**
     * Роутинг данных для модулей
     *
     * @param string $path (маркер пути controller/view)
     * @return string $str (роутинг для модулей)
     */
    public static function routingModules($path) {

        if (\eMarket\Valid::inGET('module_path')) {
            return \eMarket\Settings::modulesPath() . '/' . $path . '/' . \eMarket\Settings::path() . '/' . \eMarket\Valid::inGET('module_path');
        } else {
            return \eMarket\Settings::modulesPath() . '/' . $path . '/' . \eMarket\Settings::path();
        }
    }

    /**
     * Вывод отсортированных слоев в конкретную позицию шаблона
     * 
     * @param string $position (позиция)
     * @param string $count (маркер счетчика)
     * @return array|string (массив настроек позиций для конкретного пути)
     */
    public static function layoutRouting($position, $count = null) {

        if (self::$array_pos_value == null) {
            self::$array_pos_value = \eMarket\Pdo::getColRow("SELECT url, value FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND page=? AND template_name=? ORDER BY sort ASC", [\eMarket\Settings::path(), \eMarket\Settings::titleDir(), \eMarket\Settings::template()]);
        }
        if (count(self::$array_pos_value) > 0) {
            $array_out = [];
            foreach (self::$array_pos_value as $val) {
                if ($val[1] == $position) {
                    $path_view = str_replace('controller', 'view/' . \eMarket\Settings::template(), $val[0]);
                    $array_out[] = $val[0];
                    $array_out[] = $path_view;
                }
            }
            if ($count == 'count') {
                return count($array_out);
            }
            return $array_out;
        } else {
            if (self::$array_pos == null) {
                self::$array_pos = \eMarket\Pdo::getColRow("SELECT url, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", [\eMarket\Settings::path(), $position, \eMarket\Settings::template()]);
            }
            $array_out = [];
            foreach (self::$array_pos as $val) {
                if ($val[1] == 'all') {
                    $path_view = str_replace('controller', 'view/' . \eMarket\Settings::template(), $val[0]);
                    $array_out[] = $val[0];
                    $array_out[] = $path_view;
                }
            }
            if ($count == 'count') {
                return count($array_out);
            }
            return $array_out;
        }
    }

}

?>