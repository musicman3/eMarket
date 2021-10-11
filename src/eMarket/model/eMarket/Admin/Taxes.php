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
    Settings,
    Valid
};

/**
 * Taxes
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Taxes {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $zones = FALSE;
    public static $zones_names = FALSE;
    public static $value_6 = FALSE;
    public static $value_4 = FALSE;

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

            if (Valid::inPOST('tax_type')) {
                $tax_type = 1;
            } else {
                $tax_type = 0;
            }

            if (Valid::inPOST('fixed')) {
                $fixed = 1;
            } else {
                $fixed = 0;
            }

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_TAXES . " SET id=?, name=?, language=?, rate=?, tax_type=?, zones_id=?, fixed=?, currency=?", [
                    $id, Valid::inPOST('name_taxes_' . $x), lang('#lang_all')[$x], Valid::inPOST('rate_taxes'),
                    $tax_type, Valid::inPOST('zones_id'), $fixed, Settings::currencyDefault()[0]
                ]);
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

            if (Valid::inPOST('tax_type')) {
                $tax_type = 1;
            } else {
                $tax_type = 0;
            }

            if (Valid::inPOST('fixed')) {
                $fixed = 1;
            } else {
                $fixed = 0;
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_TAXES . " SET name=?, rate=?, tax_type=?, zones_id=?, fixed=?, currency=? WHERE id=? AND language=?", [
                    Valid::inPOST('name_taxes_' . $x), Valid::inPOST('rate_taxes'), $tax_type,
                    Valid::inPOST('zones_id'), $fixed, Settings::currencyDefault()[0],
                    Valid::inPOST('edit'), lang('#lang_all')[$x]
                ]);
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
            Pdo::action("DELETE FROM " . TABLE_TAXES . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        self::$zones = Pdo::getAssoc("SELECT * FROM " . TABLE_ZONES . " WHERE language=?", [lang('#lang_all')[0]]);

        self::$zones_names = [];
        foreach (self::$zones as $zones_val) {
            self::$zones_names[$zones_val['id']] = $zones_val['name'];
        }

        self::$value_6 = [0 => sprintf(lang('taxes_value'), Settings::currencyDefault()[2]), 1 => lang('taxes_percent')];
        self::$value_4 = [0 => lang('taxes_separately'), 1 => lang('taxes_included')];

        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_TAXES . " ORDER BY id DESC", []);
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
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $rate[$modal_id] = round((float) $sql_modal['rate'], 2);
                        $tax_type_modal[$modal_id] = (int) $sql_modal['tax_type'];
                        $zones_id[$modal_id] = (int) $sql_modal['zones_id'];
                        $fixed_modal[$modal_id] = (int) $sql_modal['fixed'];
                    }
                }

                ksort($name);
                self::$json_data = json_encode([
                    'name' => $name,
                    'rate' => $rate,
                    'tax_type' => $tax_type_modal,
                    'zones_id' => $zones_id,
                    'fixed' => $fixed_modal,
                    'zones' => self::$zones,
                    'currency' => Settings::currencyDefault()[3]
                ]);
            }
        }
    }

}
