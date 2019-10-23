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

    /**
     * Роутинг данных из View
     *
     * @return string $str (роутинг на view)
     */
    public static function routing() {

        $str = str_replace('controller', 'view/' . \eMarket\Set::template(), getenv('SCRIPT_FILENAME'));

        return $str;
    }

    /**
     * Роутинг данных из View для административной панели
     *
     * @return string $str (роутинг на view)
     */
    public static function routingAdmin() {

        if (\eMarket\Valid::inGET('object') != '') {
            $page = \eMarket\Valid::inGET('object') . '.php';
        }

        if (!\eMarket\Valid::inGET('object') OR \eMarket\Valid::inGET('object') == '') {
            $page = 'index.php';
        }

        if (\eMarket\Valid::inGET('route') != '') {
            $str = str_replace('controller', 'view/' . \eMarket\Set::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Set::path() . '/pages/' . \eMarket\Valid::inGET('route') . '/' . $page);
        } else {
            $str = str_replace('controller', 'view/' . \eMarket\Set::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Set::path() . '/pages/dashboard/index.php');
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
            $str = str_replace('controller', 'view/' . \eMarket\Set::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Set::path() . '/pages/' . \eMarket\Valid::inGET('route') . '/index.php');
        } else {
            $str = str_replace('controller', 'view/' . \eMarket\Set::template(), getenv('DOCUMENT_ROOT') . '/controller/' . \eMarket\Set::path() . '/pages/catalog/index.php');
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
     * @param string $path (маркер пути)
     * @return string $str (роутинг для модулей)
     */
    public static function routingModules($path) {

        if (\eMarket\Valid::inGET('path')) {
            return \eMarket\Set::modulesPath() . '/' . $path . '/' . \eMarket\Set::path() . '/' . \eMarket\Valid::inGET('path');
        } else {
            return \eMarket\Set::modulesPath() . '/' . $path . '/' . \eMarket\Set::path();
        }
    }

    /**
     * Вывод отсортированных слоев в конкретную позицию шаблона
     * 
     * @param string $position (позиция)
     * @return array $array_out (массив настроек позиций для конкретного пути)
     */
    public static function layoutRouting($position) {

        $array_pos_temp = \eMarket\Pdo::getColRow("SELECT url, value FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND page=? AND template_name=? ORDER BY sort ASC", [\eMarket\Set::path(), \eMarket\Set::titleDir(), \eMarket\Set::template()]);
        if (count($array_pos_temp) > 0) {
            $array_pos = $array_pos_temp;
            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == $position) {
                    $path_view = str_replace('controller', 'view/' . \eMarket\Set::template(), $val[0]);
                    $array_out[] = $val[0];
                    $array_out[] = $path_view;
                }
            }
            return $array_out;
        } else {
            $array_pos = \eMarket\Pdo::getColRow("SELECT url, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", [\eMarket\Set::path(), $position, \eMarket\Set::template()]);
            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == 'all') {
                    $path_view = str_replace('controller', 'view/' . \eMarket\Set::template(), $val[0]);
                    $array_out[] = $val[0];
                    $array_out[] = $path_view;
                }
            }
            return $array_out;
        }
    }

}

?>