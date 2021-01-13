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
    public static $discounts = FALSE;
    public static $discount_default = FALSE;
    public static $discounts_flag = FALSE;

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
     * Init Discount
     *
     */
    public static function initDiscount() {
        $installed_active = \eMarket\Pdo::getCell("SELECT id FROM " . TABLE_MODULES . " WHERE name=? AND type=? AND active=?", ['sale', 'discount', 1]);
        self::$discounts = '';
        self::$discount_default = 0;
        $discount_default_flag = 0;
        self::$discounts_flag = 0;
        $select_array = [];

        if ($installed_active != '') {
            $discounts_all = \eMarket\Pdo::getColAssoc("SELECT id, name, default_set FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=?", [lang('#lang_all')[0]]);
        }

        if ($installed_active != '' && isset($discounts_all) && count($discounts_all) > 0) {
            $this_time = time();

            foreach ($discounts_all as $val) {
                $date_end = \eMarket\Pdo::getCell("SELECT UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE id=?", [$val['id']]);
                if ($this_time < $date_end) {
                    self::$discounts_flag = 1;
                    self::$discounts .= $val['id'] . ': ' . "'" . $val['name'] . "', ";
                    array_push($select_array, $val['id']);
                    if ($val['default_set'] == 1) {
                        self::$discount_default = $val['id'];
                        $discount_default_flag = 1;
                    } elseif ($discount_default_flag == 0) {
                        self::$discount_default = $val['id'];
                        $discount_default_flag = 1;
                    }
                }
            }
        }
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
            if (file_exists(ROOT . '/modules/discount/' . $module['name'] . '/js_handler/admin/contextmenu/contextmenu.js')) {
                $text .= $module['name'] . ': Discount' . ucfirst($module['name']) . '.context(discounts_interface), ';
                $output_text = substr($text, 0, -2);
                array_push($output_modules, $module['name']);
            }
        }

        if (count($active_modules) == 0) {
            self::$discount_router['data'] = [];
            self::$discount_router['functions'] = '"---------" ';

            if ($marker == 'data') {
                return self::$discount_router['data'];
            }
            if ($marker == 'functions') {
                return self::$discount_router['functions'];
            }
        }

        $output_text .= ', "discount_separator_end": "---------"';

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