<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Messages,
    Pages,
    Valid
};
use Cruder\Db;

/**
 * Zones/Listing
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class ZonesListing {

    public static $routing_parameter = 'zones/listing';
    public $title = 'title_zones_listing_index';
    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $zones_id = FALSE;
    public static $lines = FALSE;
    public static $regions_multiselect = FALSE;
    public static $regions = FALSE;
    public static $countries_multiselect = FALSE;
    public static $countries_multiselect_temp = FALSE;
    public static $text_arr = FALSE;
    public static $count = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->zones_id();
        $this->add();
        $this->data();
        $this->tooltip();
    }

    /**
     * Zones id
     *
     */
    private function zones_id(): void {
        if (Valid::inPOST('zone_id')) {
            self::$zones_id = (int) Valid::inPOST('zone_id');
        }

        if (Valid::inGET('zone_id')) {
            self::$zones_id = (int) Valid::inGET('zone_id');
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            Db::connect()
                    ->delete(TABLE_ZONES_VALUE)
                    ->where('zones_id=', self::$zones_id)
                    ->save();

            if (Valid::inPOST('multiselect')) {
                $multiselect = Func::arrayExplode(Valid::inPOST('multiselect'), '-');
                foreach ($multiselect as $value) {

                    Db::connect()
                            ->create(TABLE_ZONES_VALUE)
                            ->set('country_id', $value[0])
                            ->set('regions_id', $value[1])
                            ->set('zones_id', self::$zones_id)
                            ->save();
                }
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$count = 0;

        self::$countries_multiselect_temp = Db::connect()
                ->read(TABLE_COUNTRIES)
                ->selectIndex('id, name')
                ->where('language=', lang('#lang_all')[0])
                ->orderByDesc('id')
                ->save();

        self::$countries_multiselect = array_column(self::$countries_multiselect_temp, 1, 0);

        asort(self::$countries_multiselect);

        self::$regions_multiselect = Db::connect()
                ->read(TABLE_REGIONS)
                ->selectAssoc('id, country_id, name, region_code')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$regions = Db::connect()
                ->read(TABLE_ZONES_VALUE)
                ->selectAssoc('country_id, regions_id')
                ->where('zones_id=', self::$zones_id)
                ->save();

        self::$sql_data = Db::connect()
                ->read(TABLE_ZONES_VALUE)
                ->selectIndex('country_id')
                ->where('zones_id=', self::$zones_id)
                ->save();

        self::$lines = array_values(array_unique(self::$sql_data, SORT_REGULAR));
        Pages::data(self::$lines);
    }

    /**
     * Tooltip data
     *
     */
    private function tooltip(): void {
        self::$text_arr = [];

        for ($y = Pages::$start; $y < Pages::$finish; $y++) {
            $text = '| ';
            for ($x = 0; $x < count(self::$regions); $x++) {
                if (isset(self::$regions[$x]['country_id']) && isset(self::$lines[$y][0]) && self::$regions[$x]['country_id'] == self::$lines[$y][0]) {
                    $text .= Func::filterArrayToKeyAssoc(self::$regions_multiselect, 'country_id', self::$regions[$x]['country_id'], 'name', 'id')[self::$regions[$x]['regions_id']] . ' | ';
                }
            }
            array_push(self::$text_arr, $text);
        }
    }

}
