<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Taxes
 *
 * @package Admin
 * @author eMarket
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
    public function add() {
        if (\eMarket\Valid::inPOST('add')) {

            if (\eMarket\Valid::inPOST('tax_type')) {
                $tax_type = 1;
            } else {
                $tax_type = 0;
            }

            if (\eMarket\Valid::inPOST('fixed')) {
                $fixed = 1;
            } else {
                $fixed = 0;
            }

            $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_TAXES . " SET id=?, name=?, language=?, rate=?, tax_type=?, zones_id=?, fixed=?, currency=?", [$id, \eMarket\Valid::inPOST('name_taxes_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('rate_taxes'), $tax_type, \eMarket\Valid::inPOST('zones_id'), $fixed, \eMarket\Settings::currencyDefault()[0]]);
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

            if (\eMarket\Valid::inPOST('tax_type')) {
                $tax_type = 1;
            } else {
                $tax_type = 0;
            }

            if (\eMarket\Valid::inPOST('fixed')) {
                $fixed = 1;
            } else {
                $fixed = 0;
            }

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("UPDATE " . TABLE_TAXES . " SET name=?, rate=?, tax_type=?, zones_id=?, fixed=?, currency=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_taxes_' . $x), \eMarket\Valid::inPOST('rate_taxes'), $tax_type, \eMarket\Valid::inPOST('zones_id'), $fixed, \eMarket\Settings::currencyDefault()[0], \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
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
            \eMarket\Pdo::action("DELETE FROM " . TABLE_TAXES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$zones = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ZONES . " WHERE language=?", [lang('#lang_all')[0]]);

        self::$zones_names = [];
        foreach (self::$zones as $zones_val) {
            self::$zones_names[$zones_val['id']] = $zones_val['name'];
        }

        self::$value_6 = [0 => sprintf(lang('taxes_value'), \eMarket\Settings::currencyDefault()[2]), 1 => lang('taxes_percent')];
        self::$value_4 = [0 => lang('taxes_separately'), 1 => lang('taxes_included')];

        self::$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_TAXES . " ORDER BY id DESC", []);
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
                        $rate[$modal_id] = round($sql_modal['rate'], 2);
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
                    'zones' => self::$zones
                ]);
            }
        }
    }

}
