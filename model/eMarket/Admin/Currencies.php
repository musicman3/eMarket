<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Currencies
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Currencies {

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
        if (\eMarket\Valid::inPOST('add')) {

            if (\eMarket\Valid::inPOST('default_value_currencies')) {
                $default_value = 1;
            } else {
                $default_value = 0;
            }

            $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_CURRENCIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_value != 0) {
                \eMarket\Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

                $value_all = \eMarket\Pdo::getColAssoc("SELECT id, value, language FROM " . TABLE_CURRENCIES, []);
                $count_value_all = count($value_all);
                for ($x = 0; $x < $count_value_all; $x++) {
                    \eMarket\Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [($value_all[$x]['value'] / \eMarket\Valid::inPOST('value_currencies')), $value_all[$x]['id'], $value_all[$x]['language']]);
                }

                for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?", [$id, \eMarket\Valid::inPOST('name_currencies_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_currencies_' . $x), \eMarket\Valid::inPOST('iso_4217_currencies'), 1, $default_value, \eMarket\Valid::inPOST('symbol_currencies'), \eMarket\Valid::inPOST('symbol_position_currencies'), \eMarket\Valid::inPOST('decimal_places_currencies')]);
                }
            } else {

                for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?", [$id, \eMarket\Valid::inPOST('name_currencies_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_currencies_' . $x), \eMarket\Valid::inPOST('iso_4217_currencies'), \eMarket\Valid::inPOST('value_currencies'), $default_value, \eMarket\Valid::inPOST('symbol_currencies'), \eMarket\Valid::inPOST('symbol_position_currencies'), \eMarket\Valid::inPOST('decimal_places_currencies')]);
                }
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

            if (\eMarket\Valid::inPOST('default_value_currencies')) {
                $default_value = 1;
            } else {
                $default_value = 0;
            }

            if ($default_value != 0) {
                \eMarket\Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

                $value_all = \eMarket\Pdo::getColAssoc("SELECT id, value, language FROM " . TABLE_CURRENCIES, []);
                $count_value_all = count($value_all);
                for ($x = 0; $x < $count_value_all; $x++) {
                    \eMarket\Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [($value_all[$x]['value'] / \eMarket\Valid::inPOST('value_currencies')), $value_all[$x]['id'], $value_all[$x]['language']]);
                }

                for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                    \eMarket\Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?, last_updated=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_currencies_' . $x), \eMarket\Valid::inPOST('code_currencies_' . $x), \eMarket\Valid::inPOST('iso_4217_currencies'), 1, $default_value, \eMarket\Valid::inPOST('symbol_currencies'), \eMarket\Valid::inPOST('symbol_position_currencies'), \eMarket\Valid::inPOST('decimal_places_currencies'), date("Y-m-d H:i:s"), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
                }
            } else {

                for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                    \eMarket\Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?, last_updated=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_currencies_' . $x), \eMarket\Valid::inPOST('code_currencies_' . $x), \eMarket\Valid::inPOST('iso_4217_currencies'), \eMarket\Valid::inPOST('value_currencies'), $default_value, \eMarket\Valid::inPOST('symbol_currencies'), \eMarket\Valid::inPOST('symbol_position_currencies'), \eMarket\Valid::inPOST('decimal_places_currencies'), date("Y-m-d H:i:s"), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
                }
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

            \eMarket\Pdo::action("DELETE FROM " . TABLE_CURRENCIES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CURRENCIES . " ORDER BY id DESC", []);
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
        $code = [];
        for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
            if (isset(\eMarket\Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = \eMarket\Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {

                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                        $code[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['code'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $iso_4217[$modal_id] = $sql_modal['iso_4217'];
                        $value[$modal_id] = (float) $sql_modal['value'];
                        $symbol[$modal_id] = $sql_modal['symbol'];
                        $symbol_position[$modal_id] = $sql_modal['symbol_position'];
                        $decimal_places[$modal_id] = (float) $sql_modal['decimal_places'];
                        $status[$modal_id] = (int) $sql_modal['default_value'];
                    }
                }

                ksort($name);
                ksort($code);

                self::$json_data = json_encode([
                    'name' => $name,
                    'code' => $code,
                    'iso_4217' => $iso_4217,
                    'value' => $value,
                    'symbol' => $symbol,
                    'symbol_position' => $symbol_position,
                    'decimal_places' => $decimal_places,
                    'default_value' => $status
                ]);
            }
        }
    }

}
