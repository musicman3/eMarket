<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use \eMarket\Core\{
    Func,
    Lang,
    Messages,
    Pages,
    Pdo,
    Valid
};

/**
 * Units
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Units {

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

            if (Valid::inPOST('default_unit')) {
                $default_unit = 1;
            } else {
                $default_unit = 0;
            }

            $id_max = Pdo::selectPrepare("SELECT id FROM " . TABLE_UNITS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_unit != 0) {
                Pdo::action("UPDATE " . TABLE_UNITS . " SET default_unit=?", [0]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_UNITS . " SET id=?, name=?, language=?, unit=?, default_unit=?", [
                    $id, Valid::inPOST('name_units_' . $x), lang('#lang_all')[$x], Valid::inPOST('unit_units_' . $x), $default_unit
                ]);
            }

            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (Valid::inPOST('edit')) {

            if (Valid::inPOST('default_unit')) {
                $default_unit = 1;
            } else {
                $default_unit = 0;
            }

            if ($default_unit != 0) {
                Pdo::action("UPDATE " . TABLE_UNITS . " SET default_unit=?", [0]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_UNITS . " SET name=?, unit=?, default_unit=? WHERE id=? AND language=?", [
                    Valid::inPOST('name_units_' . $x), Valid::inPOST('unit_units_' . $x), $default_unit, Valid::inPOST('edit'), lang('#lang_all')[$x]
                ]);
            }

            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (Valid::inPOST('delete')) {
            Pdo::action("DELETE FROM " . TABLE_UNITS . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = Pdo::getColAssoc("SELECT * FROM " . TABLE_UNITS . " ORDER BY id DESC", []);
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
                        $code[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['unit'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $default[$modal_id] = (int) $sql_modal['default_unit'];
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

}
