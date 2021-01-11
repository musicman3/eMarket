<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Regions
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Regions {

    public static $sql_data = FALSE;
    public static $country_id = FALSE;
    public static $json_data = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->countryId();
        $this->add();
        $this->edit();
        $this->delete();
        $this->data();
        $this->modal();
    }

    /**
     * Country id
     *
     */
    public function countryId() {
        if (\eMarket\Valid::inGET('country_id')) {
            self::$country_id = \eMarket\Valid::inGET('country_id');
        }
        if (\eMarket\Valid::inPOST('country_id')) {
            self::$country_id = \eMarket\Valid::inPOST('country_id');
        }
        if (self::$country_id == FALSE) {
            self::$country_id = 0;
        }
    }

    /**
     * Add
     *
     */
    public function add() {
        if (\eMarket\Valid::inPOST('add')) {

            $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_REGIONS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_REGIONS . " SET id=?, country_id=?, name=?, language=?, region_code=?", [$id, self::$country_id, \eMarket\Valid::inPOST('name_regions_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('region_code_regions')]);
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

            for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
                \eMarket\Pdo::action("UPDATE " . TABLE_REGIONS . " SET name=?, region_code=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_regions_' . $x), \eMarket\Valid::inPOST('region_code_regions'), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
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

            \eMarket\Pdo::action("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=? AND id=?", [self::$country_id, \eMarket\Valid::inPOST('delete')]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE country_id=? ORDER BY name", [self::$country_id]);
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
        $lines = \eMarket\Pages::$table['lines'];
        for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
            if (isset($lines[$i]['id']) == TRUE) {

                $modal_id = $lines[$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $region_code[$modal_id] = $sql_modal['region_code'];
                    }
                }

                ksort($name);

                self::$json_data = json_encode([
                    'name' => $name,
                    'region_code' => $region_code
                ]);
            }
        }
    }

}
