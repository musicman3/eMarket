<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Weight
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Weight {

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
        $this->data();
        $this->modal();
    }

    /**
     * Add
     *
     */
    public function add() {
        if (\eMarket\Core\Valid::inPOST('add')) {

            if (\eMarket\Core\Valid::inPOST('default_weight')) {
                $default_weight = 1;
            } else {
                $default_weight = 0;
            }

            $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_WEIGHT . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_weight != 0) {
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);

                $value_weight_all = \eMarket\Core\Pdo::getColAssoc("SELECT id, value_weight, language FROM " . TABLE_WEIGHT, []);
                $count_value_weight_all = count($value_weight_all);
                for ($x = 0; $x < $count_value_weight_all; $x++) {
                    \eMarket\Core\Pdo::action("UPDATE " . TABLE_WEIGHT . " SET value_weight=? WHERE id=? AND language=?", [($value_weight_all[$x]['value_weight'] / \eMarket\Core\Valid::inPOST('value_weight')), $value_weight_all[$x]['id'], $value_weight_all[$x]['language']]);
                }

                for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [$id, \eMarket\Core\Valid::inPOST('name_weight_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('code_weight_' . $x), 1, $default_weight]);
                }
            } else {

                for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [$id, \eMarket\Core\Valid::inPOST('name_weight_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('code_weight_' . $x), \eMarket\Core\Valid::inPOST('value_weight'), $default_weight]);
                }
            }

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (\eMarket\Core\Valid::inPOST('edit')) {

            if (\eMarket\Core\Valid::inPOST('default_weight')) {
                $default_weight = 1;
            } else {
                $default_weight = 0;
            }

            if ($default_weight != 0) {
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);

                $value_weight_all = \eMarket\Core\Pdo::getColAssoc("SELECT id, value_weight, language FROM " . TABLE_WEIGHT, []);
                $count_value_weight_all = count($value_weight_all);
                for ($x = 0; $x < $count_value_weight_all; $x++) {
                    \eMarket\Core\Pdo::action("UPDATE " . TABLE_WEIGHT . " SET value_weight=? WHERE id=? AND language=?", [($value_weight_all[$x]['value_weight'] / \eMarket\Core\Valid::inPOST('value_weight')), $value_weight_all[$x]['id'], $value_weight_all[$x]['language']]);
                }

                for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                    \eMarket\Core\Pdo::action("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_weight_' . $x), \eMarket\Core\Valid::inPOST('code_weight_' . $x), 1, $default_weight, \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
                }
            } else {

                for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                    \eMarket\Core\Pdo::action("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_weight_' . $x), \eMarket\Core\Valid::inPOST('code_weight_' . $x), \eMarket\Core\Valid::inPOST('value_weight'), $default_weight, \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
                }
            }

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Core\Valid::inPOST('delete')) {
            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_WEIGHT . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_WEIGHT . " ORDER BY id DESC", []);
        $lines = \eMarket\Core\Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        \eMarket\Core\Pages::table($lines);
    }

    /**
     * Modal
     *
     */
    public function modal() {
        self::$json_data = json_encode([]);
        $name = [];
        $code = [];
        for ($i = \eMarket\Core\Pages::$start; $i < \eMarket\Core\Pages::$finish; $i++) {
            if (isset(\eMarket\Core\Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = \eMarket\Core\Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                        $code[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['code'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $value[$modal_id] = (float) $sql_modal['value_weight'];
                        $status[$modal_id] = (int) $sql_modal['default_weight'];
                    }
                }

                ksort($name);
                ksort($code);

                self::$json_data = json_encode([
                    'name' => $name,
                    'code' => $code,
                    'value' => $value,
                    'status' => $status
                ]);
            }
        }
    }

}
