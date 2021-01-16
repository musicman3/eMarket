<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Countries
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Countries {

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

            $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_COUNTRIES . " SET id=?, name=?, language=?, alpha_2=?, alpha_3=?, address_format=?", [$id, \eMarket\Core\Valid::inPOST('name_countries_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('alpha_2_countries'), \eMarket\Core\Valid::inPOST('alpha_3_countries'), \eMarket\Core\Valid::inPOST('address_format_countries')]);
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

            for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_COUNTRIES . " SET name=?, alpha_2=?, alpha_3=?, address_format=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_countries_' . $x), \eMarket\Core\Valid::inPOST('alpha_2_countries'), \eMarket\Core\Valid::inPOST('alpha_3_countries'), \eMarket\Core\Valid::inPOST('address_format_countries'), \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
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

            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_COUNTRIES . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);
            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=?", [\eMarket\Core\Valid::inPOST('delete')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        $_SESSION['country_page'] = \eMarket\Core\Valid::inSERVER('REQUEST_URI');
        self::$sql_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_COUNTRIES . " ORDER BY name", []);
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
        for ($i = \eMarket\Core\Pages::$start; $i < \eMarket\Core\Pages::$finish; $i++) {
            if (isset(\eMarket\Core\Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = \eMarket\Core\Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $alpha_2[$modal_id] = $sql_modal['alpha_2'];
                        $alpha_3[$modal_id] = $sql_modal['alpha_3'];
                        $address_format[$modal_id] = $sql_modal['address_format'];
                    }
                }

                ksort($name);

                self::$json_data = json_encode([
                    'name' => $name,
                    'alpha_2' => $alpha_2,
                    'alpha_3' => $alpha_3,
                    'address_format' => $address_format
                ]);
            }
        }
    }

}
