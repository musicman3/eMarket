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
    Pages,
    Pdo,
    Valid,
    Messages
};

/**
 * Currencies
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Currencies {

    public static $routing_parameter = 'settings/currencies';
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
     * Default
     *
     */
    private function default(): void {
        if (Valid::inPOST('default_value_currencies')) {
            $this->default = 1;
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_CURRENCIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {
                $this->recount();
                $this->addAction($id, 1);
            } else {
                $this->addAction($id, Valid::inPOST('value_currencies'));
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Add action
     *
     * @param int|string $id ID
     * @param int|string $value Value
     */
    private function addAction(int|string $id, int|string $value): void {
        for ($x = 0; $x < Lang::$count; $x++) {
            Pdo::action("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?", [
                $id, Valid::inPOST('name_currencies_' . $x), lang('#lang_all')[$x], Valid::inPOST('code_currencies_' . $x),
                Valid::inPOST('iso_4217_currencies'), $value, $this->default, Valid::inPOST('symbol_currencies'),
                Valid::inPOST('symbol_position_currencies'), Valid::inPOST('decimal_places_currencies')
            ]);
        }
    }

    /**
     * Edit
     *
     */
    private function edit(): void {
        if (Valid::inPOST('edit')) {

            if ($this->default != 0) {
                Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);
                $this->recount();
                $this->editAction(1);
            } else {
                $this->editAction(Valid::inPOST('value_currencies'));
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit action
     *
     * @param int|string $value Value
     */
    private function editAction(int|string $value): void {
        for ($x = 0; $x < Lang::$count; $x++) {
            Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?, last_updated=? WHERE id=? AND language=?", [
                Valid::inPOST('name_currencies_' . $x), Valid::inPOST('code_currencies_' . $x), Valid::inPOST('iso_4217_currencies'), $value,
                $this->default, Valid::inPOST('symbol_currencies'), Valid::inPOST('symbol_position_currencies'),
                Valid::inPOST('decimal_places_currencies'), date("Y-m-d H:i:s"), Valid::inPOST('edit'), lang('#lang_all')[$x]
            ]);
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            Pdo::action("DELETE FROM " . TABLE_CURRENCIES . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Recount
     *
     */
    private function recount(): void {
        Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

        $data = Pdo::getAssoc("SELECT * FROM " . TABLE_CURRENCIES, []);
        foreach ($data as $value) {
            Pdo::action("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [
                ($value['value'] / Valid::inPOST('value_currencies')), $value['id'], $value['language']]);
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_CURRENCIES . " ORDER BY id DESC", []);
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

    /**
     * Default text
     *
     * @return string Output text
     */
    public static function defaultText(): string {
        $output = lang('confirm-no');
        if (Pages::$table['line']['default_value'] == 1) {
            $output = lang('confirm-yes');
        }
        return $output;
    }

}
