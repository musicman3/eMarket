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
    Valid,
};

/**
 * Weight
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
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
    public function add(): void {
        if (Valid::inPOST('add')) {

            if (Valid::inPOST('default_weight')) {
                $default_weight = 1;
            } else {
                $default_weight = 0;
            }

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_WEIGHT . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_weight != 0) {
                Pdo::action("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);

                $value_weight_all = Pdo::getAssoc("SELECT id, value_weight, language FROM " . TABLE_WEIGHT, []);
                $count_value_weight_all = count($value_weight_all);
                for ($x = 0; $x < $count_value_weight_all; $x++) {
                    Pdo::action("UPDATE " . TABLE_WEIGHT . " SET value_weight=? WHERE id=? AND language=?", [
                        ($value_weight_all[$x]['value_weight'] / Valid::inPOST('value_weight')), $value_weight_all[$x]['id'],
                        $value_weight_all[$x]['language']
                    ]);
                }

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [
                        $id, Valid::inPOST('name_weight_' . $x), lang('#lang_all')[$x],
                        Valid::inPOST('code_weight_' . $x), 1, $default_weight
                    ]);
                }
            } else {

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [
                        $id, \eMarket\Core\Valid::inPOST('name_weight_' . $x), lang('#lang_all')[$x],
                        Valid::inPOST('code_weight_' . $x), Valid::inPOST('value_weight'), $default_weight
                    ]);
                }
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit(): void {
        if (Valid::inPOST('edit')) {

            if (Valid::inPOST('default_weight')) {
                $default_weight = 1;
            } else {
                $default_weight = 0;
            }

            if ($default_weight != 0) {
                Pdo::action("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);

                $value_weight_all = Pdo::getAssoc("SELECT id, value_weight, language FROM " . TABLE_WEIGHT, []);
                $count_value_weight_all = count($value_weight_all);
                for ($x = 0; $x < $count_value_weight_all; $x++) {
                    Pdo::action("UPDATE " . TABLE_WEIGHT . " SET value_weight=? WHERE id=? AND language=?", [
                        ($value_weight_all[$x]['value_weight'] / Valid::inPOST('value_weight')), $value_weight_all[$x]['id'],
                        $value_weight_all[$x]['language']]);
                }

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [
                        Valid::inPOST('name_weight_' . $x), Valid::inPOST('code_weight_' . $x), 1, $default_weight, Valid::inPOST('edit'),
                        lang('#lang_all')[$x]
                    ]);
                }
            } else {

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [
                        Valid::inPOST('name_weight_' . $x), Valid::inPOST('code_weight_' . $x), Valid::inPOST('value_weight'), $default_weight,
                        Valid::inPOST('edit'), lang('#lang_all')[$x]
                    ]);
                }
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {
            Pdo::action("DELETE FROM " . TABLE_WEIGHT . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_WEIGHT . " ORDER BY id DESC", []);
        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::data($lines);
    }

    /**
     * Modal
     *
     */
    public function modal(): void {
        self::$json_data = json_encode([]);
        $name = [];
        $code = [];
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

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
