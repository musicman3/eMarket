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
 * Regions
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Regions {

    public static $routing_parameter = 'countries/regions';
    public $title = 'title_countries_regions_index';
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
    private function countryId(): void {
        if (Valid::inGET('country_id')) {
            self::$country_id = Valid::inGET('country_id');
        }
        if (Valid::inPOST('country_id')) {
            self::$country_id = Valid::inPOST('country_id');
        }
        if (self::$country_id == FALSE) {
            self::$country_id = 0;
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Db::connect()
                    ->read(TABLE_REGIONS)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->create(TABLE_REGIONS)
                        ->set('id', $id)
                        ->set('country_id', self::$country_id)
                        ->set('name', Valid::inPOST('name_regions_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('region_code', Valid::inPOST('region_code_regions'))
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
                        ->update(TABLE_REGIONS)
                        ->set('name', Valid::inPOST('name_regions_' . $x))
                        ->set('region_code', VValid::inPOST('region_code_regions'))
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
                    ->delete(TABLE_REGIONS)
                    ->where('country_id=', self::$country_id)
                    ->and('id=', Valid::inPOST('delete'))
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
                ->read(TABLE_REGIONS)
                ->selectAssoc('*')
                ->where('country_id=', self::$country_id)
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
        $lines = Pages::$table['lines'];
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
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
