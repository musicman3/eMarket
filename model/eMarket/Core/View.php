<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
    Settings,
    Modules,
    Valid
};

/**
 * View class
 *
 * @package View
 * @author eMarket
 * 
 */
class View {

    /**
     * Routing
     *
     * @return string $str (routing)
     */
    public static function routing() {

        $str = str_replace('controller', 'view/' . Settings::template(), getenv('SCRIPT_FILENAME'));

        return $str;
    }

    /**
     * View routing for admin
     *
     * @return string $str (view routing)
     */
    public static function routingAdmin() {

        if (Valid::inGET('route_file') != '') {
            $page = Valid::inGET('route_file') . '.php';
        }

        if (!Valid::inGET('route_file') OR Valid::inGET('route_file') == '') {
            $page = 'index.php';
        }

        if (Valid::inGET('route') != '') {
            $str = str_replace('controller', 'view/' . Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . Settings::path() . '/pages/' . Valid::inGET('route') . '/' . $page);
        } else {
            $str = str_replace('controller', 'view/' . Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . Settings::path() . '/pages/dashboard/index.php');
        }
        if (file_exists($str)) {
            return $str;
        } else {
            return false;
        }
    }

    /**
     * View routing for admin
     *
     * @return string $str (view routing)
     */
    public static function routingCatalog() {

        if (Valid::inGET('route') != '') {
            $str = str_replace('controller', 'view/' . Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . Settings::path() . '/pages/' . Valid::inGET('route') . '/index.php');
        } else {
            $str = str_replace('controller', 'view/' . Settings::template(), getenv('DOCUMENT_ROOT') . '/controller/' . Settings::path() . '/pages/catalog/index.php');
        }
        if (file_exists($str)) {
            return $str;
        } else {
            return false;
        }
    }

    /**
     * Modules routing
     *
     * @param string $path (path marker controller/view)
     * @return string $str (modules routing)
     */
    public static function routingModules($path) {

        if (Valid::inGET('module_path')) {
            return Modules::modulesPath() . '/' . $path . '/' . Settings::path() . '/' . Valid::inGET('module_path');
        } else {
            return Modules::modulesPath() . '/' . $path . '/' . Settings::path();
        }
    }

    /**
     * Template Layers Positioning Controller
     * 
     * @param string $position (position)
     * @param string $count (counter marker)
     * @return array|string (positions for paths)
     */
    public static function tlpc($position, $count = null) {

        $array_pos_value = Pdo::getColRow("SELECT url, value FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND page=? AND template_name=? ORDER BY sort ASC", [
                    Settings::path(), Settings::titleDir(), Settings::template()
        ]);
        if (count($array_pos_value) > 0) {
            $array_out = [];
            foreach ($array_pos_value as $val) {
                if ($val[1] == $position) {
                    $path_view = str_replace('controller', 'view/' . Settings::template(), $val[0]);
                    $array_out[] = $path_view;
                }
            }
            if ($count == 'count') {
                return count($array_out);
            }
            return $array_out;
        } else {
            $array_pos = Pdo::getColRow("SELECT url, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", [
                        Settings::path(), $position, Settings::template()
            ]);
            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == 'all') {
                    $path_view = str_replace('controller', 'view/' . Settings::template(), $val[0]);
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