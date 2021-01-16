<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Stikers
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Stikers {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $stikers = FALSE;
    public static $stikers_default = FALSE;
    public static $stikers_flag = FALSE;
    public static $stiker_name = FALSE;

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
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu() {
        \eMarket\Admin\HeaderMenu::$menu[\eMarket\Admin\HeaderMenu::$menu_marketing][] = ['?route=stikers', 'glyphicon glyphicon-bookmark', lang('title_stikers_index'), '', 'false'];
    }    

    /**
     * Add
     *
     */
    public function add() {
        if (\eMarket\Core\Valid::inPOST('add')) {

            if (\eMarket\Core\Valid::inPOST('default_stikers')) {
                $default_stikers = 1;
            } else {
                $default_stikers = 0;
            }

            $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_STIKERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_stikers != 0) {
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_STIKERS . " SET default_stikers=?", [0]);
            }

            for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_STIKERS . " SET id=?, name=?, language=?, default_stikers=?", [$id, \eMarket\Core\Valid::inPOST('name_stikers_' . $x), lang('#lang_all')[$x], $default_stikers]);
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

            if (\eMarket\Core\Valid::inPOST('default_stikers')) {
                $default_stikers = 1;
            } else {
                $default_stikers = 0;
            }

            if ($default_stikers != 0) {
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_STIKERS . " SET default_stikers=?", [0]);
            }

            for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_STIKERS . " SET name=?, default_stikers=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_stikers_' . $x), $default_stikers, \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
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
            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_STIKERS . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " ORDER BY id DESC", []);
        $lines = \eMarket\Core\Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        \eMarket\Core\Pages::table($lines);
    }

    /**
     * Init Stikers
     *
     */
    public static function initStikers() {
        self::$stikers = '';
        self::$stikers_default = 0;
        self::$stikers_flag = 0;
        $stikers_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [lang('#lang_all')[0]]);

        foreach ($stikers_data as $val) {
            self::$stikers_flag = 1;
            self::$stikers .= $val['id'] . ': ' . "'" . $val['name'] . "', ";
            if ($val['default_stikers'] == 1) {
                self::$stikers_default = $val['id'];
            }
        }

        self::$stiker_name = [];
        foreach ($stikers_data as $val) {
            self::$stiker_name[$val['id']] = $val['name'];
        }
    }

    /**
     * Init Eac
     */
    public static function initEac() {

        if ((\eMarket\Core\Valid::inPOST('idsx_stikerOn_key') == 'On')
                or ( \eMarket\Core\Valid::inPOST('idsx_stikerOff_key') == 'Off')) {

            $parent_id_real = (int) \eMarket\Core\Valid::inPOST('idsx_real_parent_id');

            if (\eMarket\Core\Valid::inPOST('idsx_stikerOn_key') == 'On') {
                $idx = \eMarket\Core\Func::deleteEmptyInArray(\eMarket\Core\Valid::inPOST('idsx_stiker_on_id'));
                $stiker = \eMarket\Core\Valid::inPOST('stiker');
            }

            if (\eMarket\Core\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                $idx = \eMarket\Core\Func::deleteEmptyInArray(\eMarket\Core\Valid::inPOST('idsx_stiker_off_id'));
                $stiker = '';
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория / This is category
                    \eMarket\Core\Eac::$parent_id = self::dataParentId($idx[$i]);
                    $keys = self::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if (\eMarket\Core\Valid::inPOST('idsx_stikerOn_key') == 'On' OR \eMarket\Core\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                            // Это товар / This is product
                            $stiker_id_array = \eMarket\Core\Pdo::getCol("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($stiker_id_array as $stiker_id_arr) {
                                \eMarket\Core\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET stiker=? WHERE id=?", [$stiker, $stiker_id_arr]);
                            }

                            if ($parent_id_real > 0) {
                                \eMarket\Core\Eac::$parent_id = $parent_id_real;
                            }
                        }
                    }
                } else {
                    // Это товар / This is product
                    if (\eMarket\Core\Valid::inPOST('idsx_stikerOn_key') == 'On' OR \eMarket\Core\Valid::inPOST('idsx_stikerOff_key') == 'Off') {
                        $id_prod = explode('product_', $idx[$i]);
                        \eMarket\Core\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET stiker=? WHERE id=?", [$stiker, $id_prod[1]]);
                    }
                }
            }
        }

        if (is_array(\eMarket\Core\Eac::$parent_id) == TRUE) {
            \eMarket\Core\Eac::$parent_id = 0;
        }
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
                        $default_stikers[$modal_id] = (int) $sql_modal['default_stikers'];
                    }
                }

                ksort($name);

                self::$json_data = json_encode([
                    'name' => $name,
                    'default_stikers' => $default_stikers
                ]);
            }
        }
    }

}
