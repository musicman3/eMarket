<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
    Valid
};

/**
 * Modules
 *
 * @package Modules
 * @author eMarket
 * 
 */
final class Modules {

    private static $discount_router = FALSE;
    public static $discounts = '';
    public static $discount_default = '';

    /**
     * Install module
     *
     * @param array $module Input data
     */
    public static function install($module) {

        Pdo::action("INSERT INTO " . TABLE_MODULES . " SET name=?, type=?, active=?", [$module[1], $module[0], 1]);
        Pdo::dbInstall(ROOT . '/modules/' . $module[0] . '/' . $module[1] . '/install/');
    }

    /**
     * Delete module
     *
     * @param array $module Input data
     */
    public static function uninstall($module) {
        Pdo::action("DELETE FROM " . TABLE_MODULES . " WHERE name=? AND type=?", [$module[1], $module[0]]);
        Pdo::action("DROP TABLE " . DB_PREFIX . 'modules_' . $module[0] . '_' . $module[1], []);
    }

    /**
     * Init Discount
     *
     */
    public static function initDiscount() {
        $active_modules = Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['discount', '1']);

        foreach ($active_modules as $module) {
            $discount_default_flag = 0;
            $select_array = [];
            $discounts_all = Pdo::getColAssoc("SELECT id, name, default_set FROM " . DB_PREFIX . 'modules_discount_' . $module['name'] . " WHERE language=?", [lang('#lang_all')[0]]);

            $this_time = time();

            foreach ($discounts_all as $val) {
                $date_end = Pdo::getCell("SELECT UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_' . $module['name'] . " WHERE id=?", [$val['id']]);
                if ($this_time < $date_end) {
                    self::$discounts .= $module['name'] . '_' . $val['id'] . ': ' . "'" . $val['name'] . "', ";
                    array_push($select_array, $val['id']);
                    if ($val['default_set'] == 1) {
                        self::$discount_default .= $module['name'] . '_' . $val['id'] . ': ' . "'" . $val['name'] . "', ";
                        $discount_default_flag = 1;
                    } elseif ($discount_default_flag == 0) {
                        self::$discount_default = $module['name'] . '_' . $val['id'] . ': ' . "'" . $val['name'] . "', ";
                        $discount_default_flag = 1;
                    }
                }
            }
        }
    }

    /**
     * Connecting discounts
     * @return array
     */
    public static function discountRouter($marker) {

        if (self::$discount_router != FALSE && $marker == 'data') {
            return self::$discount_router['data'];
        }
        if (self::$discount_router != FALSE && $marker == 'functions') {
            return self::$discount_router['functions'];
        }

        $active_modules = Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['discount', '1']);

        $text = '{isDivider: true},';
        $discount_router = [];
        $output_modules = [];
        foreach ($active_modules as $module) {
            if (file_exists(ROOT . '/modules/discount/' . $module['name'] . '/js_handler/admin/contextmenu/contextmenu.js')) {
                $text .= 'Discount' . ucfirst($module['name']) . '.context(discounts_interface), ';
                $output_text = substr($text, 0, -2);
                array_push($output_modules, $module['name']);
            }
        }

        if (count($active_modules) == 0) {
            self::$discount_router['data'] = [];
            self::$discount_router['functions'] = '{isDivider: true} ';

            if ($marker == 'data') {
                return self::$discount_router['data'];
            }
            if ($marker == 'functions') {
                return self::$discount_router['functions'];
            }
        }

        $output_text .= ', {isDivider: true}';

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

    /**
     * Module database name
     *
     * @return string 
     */
    public static function moduleDatabase() {

        return DB_PREFIX . 'modules_' . Valid::inGET('type') . '_' . Valid::inGET('name');
    }

    /**
     * Path to module folder
     *
     * @return string
     */
    public static function modulesPath() {

        return ROOT . '/modules/' . Valid::inGET('type') . '/' . Valid::inGET('name');
    }

}
