<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Cache,
    Func,
    Lang,
    Messages,
    Pages,
    Valid
};
use eMarket\Admin\{
    HeaderMenu,
    Eac
};
use Cruder\Db;

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
    public $title = 'title_stickers_index';
    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $stickers = [];
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

            $id_max = Db::connect()
                    ->read(TABLE_STICKERS)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {

                Db::connect()
                        ->update(TABLE_STICKERS)
                        ->set('default_stickers', 0)
                        ->save();
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->create(TABLE_STICKERS)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_stickers_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('default_stickers', $this->default)
                        ->save();
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

                Db::connect()
                        ->update(TABLE_STICKERS)
                        ->set('default_stickers', 0)
                        ->save();
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->update(TABLE_STICKERS)
                        ->set('name', Valid::inPOST('name_stickers_' . $x))
                        ->set('default_stickers', $this->default)
                        ->where('id=', Valid::inPOST('edit'))
                        ->and('language=', lang('#lang_all')[$x])
                        ->save();
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

            $all_products = Db::connect()
                    ->read(TABLE_PRODUCTS)
                    ->selectAssoc('id, sticker')
                    ->where('language=', lang('#lang_all')[0])
                    ->save();

            foreach ($all_products as $value) {
                if ($value['sticker'] == Valid::inPOST('delete')) {

                    Db::connect()
                            ->update(TABLE_PRODUCTS)
                            ->set('sticker', '')
                            ->where('id=', $value['id'])
                            ->save();
                }
            }

            Db::connect()
                    ->delete(TABLE_STICKERS)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$sql_data = Db::connect()
                ->read(TABLE_STICKERS)
                ->selectAssoc('*')
                ->orderByDesc('id')
                ->save();

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
        self::$stickers_default = 0;
        self::$stickers_flag = 0;

        $stickers_data = Db::connect()
                ->read(TABLE_STICKERS)
                ->selectAssoc('*')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        foreach ($stickers_data as $val) {
            self::$stickers_flag = 1;
            self::$stickers[$val['id']] = $val['name'];
            if ($val['default_stickers'] == 1) {
                self::$stickers_default = $val['id'];
            }
        }

        self::$stickers = self::$stickers;

        self::$sticker_name = [];
        foreach ($stickers_data as $val) {
            self::$sticker_name[$val['id']] = $val['name'];
        }
    }

    /**
     * Init Eac
     */
    public function initEac(): void {

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
                    // This is category
                    $id_cat = explode('category_', $idx[$i])[1];
                    Eac::$parent_id = Eac::dataParentId($id_cat);
                    $keys = Eac::dataKeys($id_cat);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if (Valid::inPostJson('idsx_stickerOn_key') == 'On' OR Valid::inPostJson('idsx_stickerOff_key') == 'Off') {

                            Db::connect()->update(TABLE_PRODUCTS)
                                    ->set('sticker', $sticker)
                                    ->where('parent_id=', $keys[$x])
                                    ->save();

                            $Cache = new Cache();
                            $Cache->deleteItem('core.products_' . $keys[$x]);

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }
                        }
                    }
                } else {
                    if (Valid::inPostJson('idsx_stickerOn_key') == 'On' OR Valid::inPostJson('idsx_stickerOff_key') == 'Off') {
                        $id_prod = explode('products_', $idx[$i])[1];

                        Db::connect()->update(TABLE_PRODUCTS)
                                ->set('sticker', $sticker)
                                ->where('id=', $id_prod)
                                ->save();

                        $Cache = new Cache();
                        $Cache->deleteItem('core.products_' . $id_prod);
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
