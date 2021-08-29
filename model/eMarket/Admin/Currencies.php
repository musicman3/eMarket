<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Lang,
    Pages,
    Pdo,
    Valid,
    Messages
};

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
        if (Valid::inPOST('add')) {

            if (Valid::inPOST('default_value_currencies')) {
                $default_value = 1;
            } else {
                $default_value = 0;
            }

            $id_max = Pdo::getCell("SELECT id FROM " . TABLE_CURRENCIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_value != 0) {
                Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

                $value_all = Pdo::getColAssoc("SELECT id, value, language FROM " . TABLE_CURRENCIES, []);
                $count_value_all = count($value_all);
                for ($x = 0; $x < $count_value_all; $x++) {
                    Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [
                        ($value_all[$x]['value'] / Valid::inPOST('value_currencies')), $value_all[$x]['id'], $value_all[$x]['language']]);
                }

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?", [
                        $id, Valid::inPOST('name_currencies_' . $x), lang('#lang_all')[$x], Valid::inPOST('code_currencies_' . $x),
                        Valid::inPOST('iso_4217_currencies'), 1, $default_value, Valid::inPOST('symbol_currencies'),
                        Valid::inPOST('symbol_position_currencies'), Valid::inPOST('decimal_places_currencies')
                    ]);
                }
            } else {

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?", [
                        $id, Valid::inPOST('name_currencies_' . $x), lang('#lang_all')[$x], Valid::inPOST('code_currencies_' . $x),
                        Valid::inPOST('iso_4217_currencies'), Valid::inPOST('value_currencies'), $default_value,
                        Valid::inPOST('symbol_currencies'), Valid::inPOST('symbol_position_currencies'), Valid::inPOST('decimal_places_currencies')
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
    public function edit() {
        if (Valid::inPOST('edit')) {

            if (Valid::inPOST('default_value_currencies')) {
                $default_value = 1;
            } else {
                $default_value = 0;
            }

            if ($default_value != 0) {
                Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

                $value_all = Pdo::getColAssoc("SELECT id, value, language FROM " . TABLE_CURRENCIES, []);
                $count_value_all = count($value_all);
                for ($x = 0; $x < $count_value_all; $x++) {
                    Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [
                        ($value_all[$x]['value'] / Valid::inPOST('value_currencies')), $value_all[$x]['id'], $value_all[$x]['language']
                    ]);
                }

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?, last_updated=? WHERE id=? AND language=?", [
                        Valid::inPOST('name_currencies_' . $x), Valid::inPOST('code_currencies_' . $x), Valid::inPOST('iso_4217_currencies'), 1,
                        $default_value, Valid::inPOST('symbol_currencies'), Valid::inPOST('symbol_position_currencies'),
                        Valid::inPOST('decimal_places_currencies'), date("Y-m-d H:i:s"), Valid::inPOST('edit'), lang('#lang_all')[$x]
                    ]);
                }
            } else {

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?, last_updated=? WHERE id=? AND language=?", [
                        Valid::inPOST('name_currencies_' . $x), Valid::inPOST('code_currencies_' . $x), Valid::inPOST('iso_4217_currencies'),
                        Valid::inPOST('value_currencies'), $default_value, Valid::inPOST('symbol_currencies'),
                        Valid::inPOST('symbol_position_currencies'), Valid::inPOST('decimal_places_currencies'), date("Y-m-d H:i:s"),
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
    public function delete() {
        if (Valid::inPOST('delete')) {

            Pdo::action("DELETE FROM " . TABLE_CURRENCIES . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = Pdo::getColAssoc("SELECT * FROM " . TABLE_CURRENCIES . " ORDER BY id DESC", []);
        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::data($lines);
    }

    /**
     * Modal
     *
     */
    public function modal() {
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
