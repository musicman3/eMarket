<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Files,
    Func,
    Lang,
    Messages,
    Pages,
    Pdo,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Manufacturers
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
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
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_market][1] = ['?route=manufacturers', 'bi-building', lang('title_manufacturers_index'), '', 'false'];
    }

    /**
     * Add
     *
     */
    public function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Pdo::getValue("SELECT id FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . TABLE_MANUFACTURERS . " SET id=?, name=?, language=?, site=?, logo=?", [$id, Valid::inPOST('name_manufacturers_' . $x), lang('#lang_all')[$x], Valid::inPOST('site_manufacturers'), json_encode([])]);
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

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . TABLE_MANUFACTURERS . " SET name=?, site=? WHERE id=? AND language=?", [Valid::inPOST('name_manufacturers_' . $x), Valid::inPOST('site_manufacturers'), Valid::inPOST('edit'), lang('#lang_all')[$x]]);
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Image Upload
     *
     */
    public function imgUpload(): void {
        // add before delete
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '94']); // width, height
        //array_push($resize_param, ['200','150']);
        //array_push($resize_param, ['325','244']);
        //array_push($resize_param, ['525','394']);
        //array_push($resize_param, ['850','638']);
        Files::imgUpload(TABLE_MANUFACTURERS, 'manufacturers', self::$resize_param);
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {

            Pdo::action("DELETE FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_MANUFACTURERS . " ORDER BY id DESC", []);
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
                        $site[$modal_id] = $sql_modal['site'];
                        $logo[$modal_id] = json_decode($sql_modal['logo'], true);
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
