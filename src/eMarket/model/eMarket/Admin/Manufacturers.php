<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Images,
    Func,
    Lang,
    Messages,
    Pages,
    Valid
};
use eMarket\Admin\HeaderMenu;
use Cruder\Db;

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

    public static $routing_parameter = 'manufacturers';
    public $title = 'title_manufacturers_index';
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
    private function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Db::connect()
                    ->read(TABLE_MANUFACTURERS)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->create(TABLE_MANUFACTURERS)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_manufacturers_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('site', Valid::inPOST('site_manufacturers'))
                        ->set('logo', json_encode([]))
                        ->save();
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

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->update(TABLE_MANUFACTURERS)
                        ->set('name', Valid::inPOST('name_manufacturers_' . $x))
                        ->set('site', Valid::inPOST('site_manufacturers'))
                        ->where('id=', Valid::inPOST('edit'))
                        ->and('language=', lang('#lang_all')[$x])
                        ->save();
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Image Upload
     *
     */
    private function imgUpload(): void {
        // add before delete
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '94']); // width, height
        //array_push($resize_param, ['200','150']);
        //array_push($resize_param, ['325','244']);
        //array_push($resize_param, ['525','394']);
        //array_push($resize_param, ['850','638']);

        new Images(TABLE_MANUFACTURERS, 'manufacturers', self::$resize_param);
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            Db::connect()
                    ->delete(TABLE_MANUFACTURERS)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$sql_data = Db::connect()
                ->read(TABLE_MANUFACTURERS)
                ->selectAssoc('*')
                ->orderByDesc('id')
                ->save();

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
