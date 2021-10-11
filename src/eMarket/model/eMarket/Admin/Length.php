<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Messages,
    Pdo,
    Pages,
    Lang,
    Valid
};

/**
 * Length
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Length {

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

            if (Valid::inPOST('default_length')) {
                $default_length = 1;
            } else {
                $default_length = 0;
            }

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_LENGTH . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_length != 0) {
                Pdo::action("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

                $value_length_all = Pdo::getAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
                $count_value_length_all = count($value_length_all);
                for ($x = 0; $x < $count_value_length_all; $x++) {
                    Pdo::action("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [
                        ($value_length_all[$x]['value_length'] / Valid::inPOST('value_length')), $value_length_all[$x]['id'],
                        $value_length_all[$x]['language']
                    ]);
                }

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [
                        $id, Valid::inPOST('name_length_' . $x), lang('#lang_all')[$x], Valid::inPOST('code_length_' . $x), 1,
                        $default_length
                    ]);
                }
            } else {

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [
                        $id, Valid::inPOST('name_length_' . $x), lang('#lang_all')[$x], Valid::inPOST('code_length_' . $x),
                        Valid::inPOST('value_length'), $default_length]
                    );
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

            if (Valid::inPOST('default_length')) {
                $default_length = 1;
            } else {
                $default_length = 0;
            }

            if ($default_length != 0) {
                Pdo::action("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

                $value_length_all = Pdo::getAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
                $count_value_length_all = count($value_length_all);
                for ($x = 0; $x < $count_value_length_all; $x++) {
                    \Pdo::action("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [
                        ($value_length_all[$x]['value_length'] / Valid::inPOST('value_length')), $value_length_all[$x]['id'],
                        $value_length_all[$x]['language']
                    ]);
                }

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [
                        Valid::inPOST('name_length_' . $x), Valid::inPOST('code_length_' . $x), 1, $default_length,
                        Valid::inPOST('edit'), lang('#lang_all')[$x]
                    ]);
                }
            } else {

                for ($x = 0; $x < Lang::$count; $x++) {
                    Pdo::action("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [
                        Valid::inPOST('name_length_' . $x), Valid::inPOST('code_length_' . $x),
                        Valid::inPOST('value_length'), $default_length, Valid::inPOST('edit'), lang('#lang_all')[$x]
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
            Pdo::action("DELETE FROM " . TABLE_LENGTH . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_LENGTH . " ORDER BY id DESC", []);
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
                        $value_length[$modal_id] = (float) $sql_modal['value_length'];
                        $status[$modal_id] = (int) $sql_modal['default_length'];
                    }
                }

                ksort($name);
                ksort($code);

                self::$json_data = json_encode([
                    'name' => $name,
                    'code' => $code,
                    'value_length' => $value_length,
                    'default_length' => $status
                ]);
            }
        }
    }

}
