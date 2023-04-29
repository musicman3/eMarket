<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Clock\SystemClock,
    Valid
};
use Cruder\Db;

/**
 * Modules
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class Modules {

    private static $discount_router = [];
    public static $discounts = [];
    public static $discount_default = [];

    /**
     * Install module
     *
     * @param array $module Input data
     */
    public static function install(array $module): void {

        Db::connect()->create(TABLE_MODULES)
                ->set('name', $module[1])
                ->set('type', $module[0])
                ->set('active', 1)
                ->save();

        Db::connect()->dbInstall(ROOT . '/modules/' . $module[0] . '/' . $module[1] . '/install/' . DB_TYPE . '.sql');
    }

    /**
     * Delete module
     *
     * @param array $module Input data
     */
    public static function uninstall(array $module): void {

        Db::connect()->delete(TABLE_MODULES)
                ->where('name=', $module[1])
                ->and('type=', $module[0])
                ->save();

        Db::connect()->drop(DB_PREFIX . 'modules_' . $module[0] . '_' . $module[1])->save();
    }

    /**
     * Init Discount
     *
     */
    public static function initDiscount(): void {

        $active_modules = Db::connect()
                ->read(TABLE_MODULES)
                ->selectAssoc('*')
                ->where('type=', 'discount')
                ->and('active=', '1')
                ->save();

        foreach ($active_modules as $module) {
            $discount_default_flag = 0;
            $select_array = [];

            $discounts_all = Db::connect()
                    ->read(DB_PREFIX . 'modules_discount_' . $module['name'])
                    ->selectAssoc('id, name, default_set')
                    ->where('language=', lang('#lang_all')[0])
                    ->save();

            $this_time = SystemClock::nowUnixTime();

            foreach ($discounts_all as $val) {

                $date_end = Db::connect()
                        ->read(DB_PREFIX . 'modules_discount_' . $module['name'])
                        ->selectValue('{{UNIX_TIMESTAMP->date_end}}')
                        ->where('id=', $val['id'])
                        ->save();

                if ($this_time < $date_end) {
                    self::$discounts[$module['name'] . '_' . $val['id']] = $val['name'];
                    array_push($select_array, $val['id']);
                    if ($val['default_set'] == 1) {
                        self::$discount_default[$module['name'] . '_' . $val['id']] = $val['name'];
                        $discount_default_flag = 1;
                    } elseif ($discount_default_flag == 0) {
                        self::$discount_default[$module['name'] . '_' . $val['id']] = $val['name'];
                        $discount_default_flag = 1;
                    }
                }
            }
        }
    }

    /**
     * Connecting discounts
     * @return array|string
     */
    public static function discountRouter(string $marker): array|string {

        if (count(self::$discount_router) > 0 && $marker == 'data') {
            return self::$discount_router['data'];
        }
        if (count(self::$discount_router) > 0 && $marker == 'functions') {
            return self::$discount_router['functions'];
        }

        $active_modules = Db::connect()
                ->read(TABLE_MODULES)
                ->selectAssoc('*')
                ->where('type=', 'discount')
                ->and('active=', '1')
                ->save();

        $text = '{isDivider: true},';
        $discount_router = [];
        $output_modules = [];
        foreach ($active_modules as $module) {
            if (file_exists(ROOT . '/modules/discount/' . $module['name'] . '/js_handler/admin/contextmenu/contextmenu.js')) {
                $text .= ' Discount' . ucfirst($module['name']) . '.context(discounts_interface), ';
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
     * Add Discounts to ContextMenu
     *
     * @return string 
     */
    public static function addDiscountsToContextMenu(): string {

        $context = file_get_contents(ROOT . '/js_handler/admin/pages/stock/context.js');
        $find = '// ---------- Discounts ----------';
        $replace = self::discountRouter('functions') . ', // ---------- Discounts ----------';
        $output = str_replace($find, $replace, $context);
        return $output;
    }

    /**
     * Module database name
     *
     * @return string 
     */
    public static function moduleDatabase(): string {

        return DB_PREFIX . 'modules_' . Valid::inGET('type') . '_' . Valid::inGET('name');
    }

    /**
     * Path to module folder
     *
     * @return string
     */
    public static function modulesPath(): string {

        return ROOT . '/modules/' . Valid::inGET('type') . '/' . Valid::inGET('name');
    }

}
