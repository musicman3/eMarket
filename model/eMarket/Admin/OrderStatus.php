<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Order Status
 *
 * @package Admin
 * @author eMarket
 * 
 */
class OrderStatus {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->add();
        $this->edit();
        $this->delete();
        $this->sorting();
        $this->data();
        $this->modal();
    }

    /**
     * Add
     *
     */
    public function add() {
        if (\eMarket\Valid::inPOST('add')) {

            if (\eMarket\Valid::inPOST('default_order_status')) {
                $default_order_status = 1;
            } else {
                $default_order_status = 0;
            }

            $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_order_status != 0) {
                \eMarket\Pdo::action("UPDATE " . TABLE_ORDER_STATUS . " SET default_order_status=?", [0]);
            }

            $id_max_sort = \eMarket\Pdo::selectPrepare("SELECT sort FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
            $id_sort = intval($id_max_sort) + 1;

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_ORDER_STATUS . " SET id=?, name=?, language=?, default_order_status=?, sort=?", [$id, \eMarket\Valid::inPOST('name_order_status_' . $x), lang('#lang_all')[$x], $default_order_status, $id_sort]);
            }

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (\eMarket\Valid::inPOST('edit')) {

            if (\eMarket\Valid::inPOST('default_order_status')) {
                $default_order_status = 1;
            } else {
                $default_order_status = 0;
            }

            if ($default_order_status != 0) {
                \eMarket\Pdo::action("UPDATE " . TABLE_ORDER_STATUS . " SET default_order_status=?", [0]);
            }

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("UPDATE " . TABLE_ORDER_STATUS . " SET name=?, default_order_status=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_order_status_' . $x), $default_order_status, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
            }

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Valid::inPOST('delete')) {
            \eMarket\Pdo::action("DELETE FROM " . TABLE_ORDER_STATUS . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Sorting
     *
     */
    public function sorting() {
        if (\eMarket\Valid::inPOST('ids')) {
            $sort_array_id_ajax = explode(',', \eMarket\Valid::inPOST('ids'));
            $sort_array_id = \eMarket\Func::deleteEmptyInArray($sort_array_id_ajax);
            $sort_array_order_status = [];

            foreach ($sort_array_id as $val) {
                $sort_order_status = \eMarket\Pdo::selectPrepare("SELECT sort FROM " . TABLE_ORDER_STATUS . " WHERE id=? AND language=? ORDER BY id ASC", [$val, lang('#lang_all')[0]]);
                array_push($sort_array_order_status, $sort_order_status);
                arsort($sort_array_order_status);
            }

            $sort_array_final = array_combine($sort_array_id, $sort_array_order_status);

            foreach ($sort_array_id as $val) {

                \eMarket\Pdo::action("UPDATE " . TABLE_ORDER_STATUS . " SET sort=? WHERE id=?", [(int) $sort_array_final[$val], (int) $val]);
            }
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " ORDER BY sort DESC", []);
        $lines = \eMarket\Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        \eMarket\Pages::table($lines);
    }

    /**
     * Modal
     *
     */
    public function modal() {
        self::$json_data = json_encode([]);
        $name = [];
        for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
            if (isset(\eMarket\Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = \eMarket\Pages::$table['lines'][$i]['id'];

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

}
