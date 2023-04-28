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
 * Order Status
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class OrderStatus {

    public static $routing_parameter = 'order_status';
    public $title = 'title_order_status_index';
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
        $this->sorting();
        $this->data();
        $this->modal();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=order_status', 'bi-pin-angle-fill', lang('title_order_status_index'), '', 'false'];
    }

    /**
     * Default
     *
     */
    private function default(): void {
        if (Valid::inPOST('default_order_status')) {
            $this->default = 1;
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $order_status = Db::connect()
                    ->read(TABLE_ORDER_STATUS)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id_max = $order_status['id'];

            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {
                $this->recount();
            }

            $id_max_sort = $order_status['sort'];

            $id_sort = intval($id_max_sort) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->create(TABLE_ORDER_STATUS)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_order_status_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('default_order_status', $this->default)
                        ->set('sort', $id_sort)
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
                        ->update(TABLE_ORDER_STATUS)
                        ->set('name', Valid::inPOST('name_order_status_' . $x))
                        ->set('default_order_status', $this->default)
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
                    ->delete(TABLE_ORDER_STATUS)
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
                ->update(TABLE_ORDER_STATUS)
                ->set('default_order_status', 0)
                ->save();
    }

    /**
     * Sorting
     *
     */
    private function sorting(): void {
        if (Valid::inPostJson('ids')) {
            $sort_array_id_ajax = explode(',', Valid::inPostJson('ids'));
            $sort_array_id = Func::deleteEmptyInArray($sort_array_id_ajax);
            $sort_array_order_status = [];

            foreach ($sort_array_id as $val) {

                $sort_order_status = Db::connect()
                        ->read(TABLE_ORDER_STATUS)
                        ->selectValue('sort')
                        ->where('id=', $val)
                        ->and('language=', lang('#lang_all')[0])
                        ->orderByAsc('id')
                        ->save();

                array_push($sort_array_order_status, $sort_order_status);
                arsort($sort_array_order_status);
            }

            $sort_array_final = array_combine($sort_array_id, $sort_array_order_status);

            foreach ($sort_array_id as $val) {

                Db::connect()
                        ->update(TABLE_ORDER_STATUS)
                        ->set('sort', (int) $sort_array_final[$val])
                        ->where('id=', (int) $val)
                        ->save();
            }
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$sql_data = Db::connect()
                ->read(TABLE_ORDER_STATUS)
                ->selectAssoc('*')
                ->orderByDesc('sort')
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
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $status[$modal_id] = (int) $sql_modal['default_order_status'];
                    }
                }

                ksort($name);

                self::$json_data = json_encode([
                    'name' => $name,
                    'default_order_status' => $status
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
        if (Pages::$table['line']['default_order_status'] == 1) {
            $output = lang('confirm-yes');
        }
        return $output;
    }

}
