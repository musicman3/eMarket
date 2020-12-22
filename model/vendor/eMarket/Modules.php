<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для модулей / Class for modules
 *
 * @package Modules
 * @author eMarket
 * 
 */
final class Modules {

    private static $discount_router = FALSE;

    /**
     * Инсталляция модуля / Install module
     *
     * @param array $module (входящие данные / input data)
     */
    public static function install($module) {

        \eMarket\Pdo::action("INSERT INTO " . TABLE_MODULES . " SET name=?, type=?, active=?", [$module[1], $module[0], 1]);
        \eMarket\Pdo::dbInstall(ROOT . '/modules/' . $module[0] . '/' . $module[1] . '/install/');
    }

    /**
     * Удаление модуля / Delete module
     *
     * @param array $module (входящие данные / input data)
     */
    public static function uninstall($module) {
        \eMarket\Pdo::action("DELETE FROM " . TABLE_MODULES . " WHERE name=? AND type=?", [$module[1], $module[0]]);
        \eMarket\Pdo::action("DROP TABLE " . DB_PREFIX . 'modules_' . $module[0] . '_' . $module[1], []);
    }

    /**
     * Подключение скидок / Connecting discounts
     * @return array $output
     */
    public static function discountRouter($marker) {

        if (self::$discount_router != FALSE && $marker == 'data') {
            return self::$discount_router['data'];
        }
        if (self::$discount_router != FALSE && $marker == 'functions') {
            return self::$discount_router['functions'];
        }

        $active_modules = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['discount', '1']);

        $text = '"---------", ';
        $discount_router = [];
        $output_modules = [];
        foreach ($active_modules as $module) {
            if (file_exists(ROOT . '/modules/discount/' . $module['name'] . '/controller/admin/js/contextmenu/contextmenu.js')) {
                $text .= $module['name'] . ': Discount' . ucfirst($module['name']) . '.context(sales_interface), ';
                $output_text = substr($text, 0, -2);
                array_push($output_modules, $module['name']);
            }
        }

        if (count($active_modules) == 0) {
            self::$discount_router['data'] = [];
            self::$discount_router['functions'] = '';
            
            if ($marker == 'data') {
                return self::$discount_router['data'];
            }
            if ($marker == 'functions') {
                return self::$discount_router['functions'];
            }
        }

        if ($marker == 'data') {
            return $output_modules;
        }
        if ($marker == 'functions') {
            return $output_text;
        }

        self::$discount_router['data'] = $output_modules;
        self::$discount_router['functions'] = $output_text;

        return self::$discount_router;
    }

}

?>