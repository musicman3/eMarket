<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Manufacturers
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Manufacturers {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $resize_param;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->add();
        $this->edit();
        $this->imgUpload();
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
        \eMarket\Admin\HeaderMenu::$menu[\eMarket\Admin\HeaderMenu::$menu_market][1] = ['?route=manufacturers', 'glyphicon glyphicon-object-align-bottom', lang('title_manufacturers_index'), '', 'false'];
    }

    /**
     * Add
     *
     */
    public function add() {
        if (\eMarket\Core\Valid::inPOST('add')) {

            $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_MANUFACTURERS . " SET id=?, name=?, language=?, site=?, logo=?", [$id, \eMarket\Core\Valid::inPOST('name_manufacturers_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('site_manufacturers'), json_encode([])]);
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
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_MANUFACTURERS . " SET name=?, site=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_manufacturers_' . $x), \eMarket\Core\Valid::inPOST('site_manufacturers'), \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
            }

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Image Upload
     *
     */
    public function imgUpload() {
        // add before delete
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '94']); // width, height
        //array_push($resize_param, ['200','150']);
        //array_push($resize_param, ['325','244']);
        //array_push($resize_param, ['525','394']);
        //array_push($resize_param, ['850','638']);
        \eMarket\Core\Files::imgUpload(TABLE_MANUFACTURERS, 'manufacturers', self::$resize_param);
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Core\Valid::inPOST('delete')) {

            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$sql_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_MANUFACTURERS . " ORDER BY id DESC", []);
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
                        $site[$modal_id] = $sql_modal['site'];
                        $logo[$modal_id] = json_decode($sql_modal['logo'], 1);
                        $logo_general[$modal_id] = $sql_modal['logo_general'];
                    }
                }
                ksort($name);

                self::$json_data = json_encode([
                    'name' => $name,
                    'site' => $site,
                    'logo' => $logo,
                    'logo_general' => $logo_general
                ]);
            }
        }
    }

}
