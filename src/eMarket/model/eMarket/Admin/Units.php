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
 * Units
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Units {

    public static $routing_parameter = 'units';
    public $title = 'title_units_index';
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
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=units', 'bi-flag-fill', lang('title_units_index'), '', 'false'];
    }

    /**
     * Default
     *
     */
    private function default(): void {
        if (Valid::inPOST('default_unit')) {
            $this->default = 1;
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_UNITS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {
                $this->recount();
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_UNITS . " SET id=?, name=?, language=?, unit=?, default_unit=?", [
                    $id, Valid::inPOST('name_units_' . $x), lang('#lang_all')[$x], Valid::inPOST('unit_units_' . $x), $this->default
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
                Pdo::action("UPDATE " . TABLE_UNITS . " SET name=?, unit=?, default_unit=? WHERE id=? AND language=?", [
                    Valid::inPOST('name_units_' . $x), Valid::inPOST('unit_units_' . $x), $this->default, Valid::inPOST('edit'), lang('#lang_all')[$x]
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
            Pdo::action("DELETE FROM " . TABLE_UNITS . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Recount
     *
     */
    private function recount(): void {
        Pdo::action("UPDATE " . TABLE_UNITS . " SET default_unit=?", [0]);
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_UNITS . " ORDER BY id DESC", []);
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

    /**
     * Default text
     *
     * @return string Output text
     */
    public static function defaultText(): string {
        $output = lang('confirm-no');
        if (Pages::$table['line']['default_unit'] == 1) {
            $output = lang('confirm-yes');
        }
        return $output;
    }

}
