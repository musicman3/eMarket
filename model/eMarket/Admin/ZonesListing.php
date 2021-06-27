<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

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
 * @author eMarket
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
    public function zones_id() {
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
    public function add() {
        if (Valid::inPOST('add')) {

            Pdo::action("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);

            if (empty(Valid::inPOST('multiselect')) == FALSE) {
                $multiselect = Func::arrayExplode(Valid::inPOST('multiselect'), '-');
                for ($x = 0; $x < count($multiselect); $x++) {
                    Pdo::action("INSERT INTO " . TABLE_ZONES_VALUE . " SET country_id=?, regions_id=?, zones_id=?", [
                        $multiselect[$x][0], $multiselect[$x][1], self::$zones_id
                    ]);
                }
            }

            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$count = 0;

        self::$countries_multiselect_temp = Pdo::getColRow("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
        self::$countries_multiselect = array_column(self::$countries_multiselect_temp, 1, 0);

        asort(self::$countries_multiselect);

        self::$regions_multiselect = Pdo::getColAssoc("SELECT id, country_id, name, region_code  FROM " . TABLE_REGIONS . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$regions = Pdo::getColAssoc("SELECT country_id, regions_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);

        self::$sql_data = Pdo::getColRow("SELECT country_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);
        self::$lines = array_values(array_unique(self::$sql_data, SORT_REGULAR));
        Pages::data(self::$lines);
    }

    /**
     * Tooltip data
     *
     */
    public function tooltip() {
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
