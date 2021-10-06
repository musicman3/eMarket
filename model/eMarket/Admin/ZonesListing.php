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
    Pdo,
    Valid
};

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
    public function zones_id(): void {
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
    public function add(): void {
        if (Valid::inPOST('add')) {

            Pdo::action("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);

            if (Valid::inPOST('multiselect')) {
                $multiselect = Func::arrayExplode(Valid::inPOST('multiselect'), '-');
                foreach ($multiselect as $value) {
                    Pdo::action("INSERT INTO " . TABLE_ZONES_VALUE . " SET country_id=?, regions_id=?, zones_id=?", [
                        $value[0], $value[1], self::$zones_id
                    ]);
                }
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        self::$count = 0;

        self::$countries_multiselect_temp = Pdo::getIndex("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
        self::$countries_multiselect = array_column(self::$countries_multiselect_temp, 1, 0);

        asort(self::$countries_multiselect);

        self::$regions_multiselect = Pdo::getAssoc("SELECT id, country_id, name, region_code  FROM " . TABLE_REGIONS . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$regions = Pdo::getAssoc("SELECT country_id, regions_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);

        self::$sql_data = Pdo::getIndex("SELECT country_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);
        self::$lines = array_values(array_unique(self::$sql_data, SORT_REGULAR));
        Pages::data(self::$lines);
    }

    /**
     * Tooltip data
     *
     */
    public function tooltip(): void {
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
