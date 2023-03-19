<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Cache,
    Eac,
    Func,
    Lang,
    Messages,
    Pages,
    Pdo,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Stickers
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Stickers {

    public static $routing_parameter = 'stickers';
    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $stickers = FALSE;
    public static $stickers_default = FALSE;
    public static $stickers_flag = FALSE;
    public static $sticker_name = FALSE;
    public int $default = 0;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->default();
        $this->add();
        $this->edit();
        $this->delete();
        $this->data();
        $this->modal();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_marketing][] = ['?route=stickers', 'bi-bookmark-star-fill', lang('title_stickers_index'), '', 'false'];
    }

    /**
     * Default
     *
     */
    private function default(): void {
        if (Valid::inPOST('default_stickers')) {
            $this->default = 1;
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_STICKERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {
                Pdo::action("UPDATE " . TABLE_STICKERS . " SET default_stickers=?", [0]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_STICKERS . " SET id=?, name=?, language=?, default_stickers=?", [
                    $id, Valid::inPOST('name_stickers_' . $x), lang('#lang_all')[$x], $this->default
                ]);
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    private function edit(): void {
        if (Valid::inPOST('edit')) {

            if ($this->default != 0) {
                Pdo::action("UPDATE " . TABLE_STICKERS . " SET default_stickers=?", [0]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_STICKERS . " SET name=?, default_stickers=? WHERE id=? AND language=?", [
                    Valid::inPOST('name_stickers_' . $x), $this->default, Valid::inPOST('edit'), lang('#lang_all')[$x]
                ]);
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {
            Pdo::action("DELETE FROM " . TABLE_STICKERS . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_STICKERS . " ORDER BY id DESC", []);
        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::data($lines);
    }

    /**
     * Modal
     *
     */
    private function modal(): void {
        self::$json_data = json_encode([]);
        $name = [];
        $status = [];
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $status[$modal_id] = (int) $sql_modal['default_stickers'];
                    }
                }

                ksort($name);

                self::$json_data = json_encode([
                    'name' => $name,
                    'default_stickers' => $status
                ]);
            }
        }
    }

    /**
     * Init Stickers
     *
     */
    public static function initStickers(): void {
        self::$stickers = '';
        self::$stickers_default = 0;
        self::$stickers_flag = 0;
        $stickers_data = Pdo::getAssoc("SELECT * FROM " . TABLE_STICKERS . " WHERE language=?", [lang('#lang_all')[0]]);

        foreach ($stickers_data as $val) {
            self::$stickers_flag = 1;
            self::$stickers .= $val['id'] . ': ' . "'" . $val['name'] . "', ";
            if ($val['default_stickers'] == 1) {
                self::$stickers_default = $val['id'];
            }
        }

        self::$sticker_name = [];
        foreach ($stickers_data as $val) {
            self::$sticker_name[$val['id']] = $val['name'];
        }
    }

    /**
     * Init Eac
     */
    public static function initEac(): void {

        if ((Valid::inPostJson('idsx_stickerOn_key') == 'On')
                or (Valid::inPostJson('idsx_stickerOff_key') == 'Off')) {

            $parent_id_real = (int) Valid::inPostJson('idsx_real_parent_id');

            if (Valid::inPostJson('idsx_stickerOn_key') == 'On') {
                $idx = Func::deleteEmptyInArray(Valid::inPostJson('idsx_sticker_on_id'));
                $sticker = Valid::inPostJson('sticker');
            }

            if (Valid::inPostJson('idsx_stickerOff_key') == 'Off') {
                $idx = Func::deleteEmptyInArray(Valid::inPostJson('idsx_sticker_off_id'));
                $sticker = '';
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'products') {
                    Eac::$parent_id = self::dataParentId($idx[$i]);
                    $keys = self::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if (Valid::inPostJson('idsx_stickerOn_key') == 'On' OR Valid::inPostJson('idsx_stickerOff_key') == 'Off') {

                            $sticker_id_array = Pdo::getAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [
                                        lang('#lang_all')[0], $keys[$x]
                            ]);

                            foreach ($sticker_id_array as $sticker_id_arr) {
                                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET sticker=? WHERE id=?", [$sticker, $sticker_id_arr]);
                            }

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }

                            $Cache = new Cache();
                            $Cache->deleteItem('core.products_' . $sticker_id_arr);
                        }
                    }
                } else {
                    if (Valid::inPostJson('idsx_stickerOn_key') == 'On' OR Valid::inPostJson('idsx_stickerOff_key') == 'Off') {
                        $id_prod = explode('products_', $idx[$i]);
                        Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET sticker=? WHERE id=?", [$sticker, $id_prod[1]]);

                        $Cache = new Cache();
                        $Cache->deleteItem('core.products_' . $id_prod[1]);
                    }
                }

                Messages::alert('sticker_actions', 'success', lang('action_completed_successfully'), 0, true);
            }
        }

        if (is_array(Eac::$parent_id) == TRUE) {
            Eac::$parent_id = 0;
        }
    }

    /**
     * Default text
     *
     * @return string Output text
     */
    public static function defaultText(): string {
        $output = lang('confirm-no');
        if (Pages::$table['line']['default_stickers'] == 1) {
            $output = lang('confirm-yes');
        }
        return $output;
    }

}
