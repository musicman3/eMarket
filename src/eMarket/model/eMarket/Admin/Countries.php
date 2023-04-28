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
    Valid
};
use Cruder\Db;

/**
 * Countries
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Countries {

    public static $routing_parameter = 'countries';
    public $title = 'title_countries_index';
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
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=countries', 'bi-globe', lang('title_countries_index'), '', 'false'];
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Db::connect()
                    ->read(TABLE_COUNTRIES)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {
                Db::connect()
                        ->create(TABLE_COUNTRIES)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_countries_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('alpha_2', Valid::inPOST('alpha_2_countries'))
                        ->set('alpha_3', Valid::inPOST('alpha_3_countries'))
                        ->set('address_format', Valid::inPOST('address_format_countries'))
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
                        ->update(TABLE_COUNTRIES)
                        ->set('name', Valid::inPOST('name_countries_' . $x))
                        ->set('alpha_2', Valid::inPOST('alpha_2_countries'))
                        ->set('alpha_3', Valid::inPOST('alpha_3_countries'))
                        ->set('address_format', Valid::inPOST('address_format_countries'))
                        ->where('id=', Valid::inPOST('edit'))
                        ->and('language=', lang('#lang_all')[$x])
                        ->save();
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

            Db::connect()
                    ->delete(TABLE_COUNTRIES)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Db::connect()
                    ->delete(TABLE_REGIONS)
                    ->where('country_id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        $_SESSION['country_page'] = Valid::inSERVER('REQUEST_URI');

        self::$sql_data = Db::connect()
                ->read(TABLE_COUNTRIES)
                ->selectAssoc('*')
                ->orderBy('name')
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
