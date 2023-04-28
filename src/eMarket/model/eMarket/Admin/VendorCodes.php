<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Lang,
    Messages,
    Pages,
    Valid
};
use Cruder\Db;

/**
 * Vendor Codes
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class VendorCodes {

    public static $routing_parameter = 'vendor_codes';
    public $title = 'title_vendor_codes_index';
    public static $sql_data = FALSE;
    public static $json_data = FALSE;
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
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=vendor_codes', 'bi-tag-fill', lang('title_vendor_codes_index'), '', 'false'];
    }

    /**
     * Default
     *
     */
    private function default(): void {
        if (Valid::inPOST('default_vendor_code')) {
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
                    ->read(TABLE_VENDOR_CODES)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {
                $this->recount();
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->create(TABLE_VENDOR_CODES)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_vendor_codes_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('vendor_code', Valid::inPOST('vendor_code_' . $x))
                        ->set('default_vendor_code', $this->default)
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
                $this->recount();
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->update(TABLE_VENDOR_CODES)
                        ->set('name', Valid::inPOST('name_vendor_codes_' . $x))
                        ->set('vendor_code', Valid::inPOST('vendor_code_' . $x))
                        ->set('default_vendor_code', $this->default)
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

            Db::connect()
                    ->delete(TABLE_VENDOR_CODES)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Recount
     *
     */
    private function recount(): void {
        Db::connect()
                ->update(TABLE_VENDOR_CODES)
                ->set('default_vendor_code', 0)
                ->save();
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$sql_data = Db::connect()
                ->read(TABLE_VENDOR_CODES)
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
        $code = [];
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                        $code[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['vendor_code'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $default[$modal_id] = (int) $sql_modal['default_vendor_code'];
                    }
                }

                ksort($name);
                ksort($code);

                self::$json_data = json_encode([
                    'name' => $name,
                    'code' => $code,
                    'default' => $default
                ]);
            }
        }
    }

    /**
     * Default text
     *
     * @return string Output text
     */
    public static function defaultText(): string {
        $output = lang('confirm-no');
        if (Pages::$table['line']['default_vendor_code'] == 1) {
            $output = lang('confirm-yes');
        }
        return $output;
    }

}
