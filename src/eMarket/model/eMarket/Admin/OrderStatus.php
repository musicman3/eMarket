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
    Pdo,
    Valid
};

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

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {
                $this->recount();
            }

            $id_max_sort = Pdo::getValue("SELECT sort FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
            $id_sort = intval($id_max_sort) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_ORDER_STATUS . " SET id=?, name=?, language=?, default_order_status=?, sort=?", [
                    $id, Valid::inPOST('name_order_status_' . $x), lang('#lang_all')[$x], $this->default, $id_sort
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
                $this->recount();
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_ORDER_STATUS . " SET name=?, default_order_status=? WHERE id=? AND language=?", [
                    Valid::inPOST('name_order_status_' . $x), $this->default, Valid::inPOST('edit'),
                    lang('#lang_all')[$x]
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
            Pdo::action("DELETE FROM " . TABLE_ORDER_STATUS . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Recount
     *
     */
    private function recount(): void {
        Pdo::action("UPDATE " . TABLE_ORDER_STATUS . " SET default_order_status=?", [0]);
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
                $sort_order_status = Pdo::getValue("SELECT sort FROM " . TABLE_ORDER_STATUS . " WHERE id=? AND language=? ORDER BY id ASC", [
                            $val, lang('#lang_all')[0]
                ]);
                array_push($sort_array_order_status, $sort_order_status);
                arsort($sort_array_order_status);
            }

            $sort_array_final = array_combine($sort_array_id, $sort_array_order_status);

            foreach ($sort_array_id as $val) {

                Pdo::action("UPDATE " . TABLE_ORDER_STATUS . " SET sort=? WHERE id=?", [(int) $sort_array_final[$val], (int) $val]);
            }
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " ORDER BY sort DESC", []);
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
