<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

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
        if (\eMarket\Core\Valid::inPOST('zone_id')) {
            self::$zones_id = (int) \eMarket\Core\Valid::inPOST('zone_id');
        }

        if (\eMarket\Core\Valid::inGET('zone_id')) {
            self::$zones_id = (int) \eMarket\Core\Valid::inGET('zone_id');
        }
    }

    /**
     * Add
     *
     */
    public function add() {
        if (\eMarket\Core\Valid::inPOST('add')) {

            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);

            if (empty(\eMarket\Core\Valid::inPOST('multiselect')) == FALSE) {
                $multiselect = \eMarket\Core\Func::arrayExplode(\eMarket\Core\Valid::inPOST('multiselect'), '-');
                for ($x = 0; $x < count($multiselect); $x++) {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_ZONES_VALUE . " SET country_id=?, regions_id=?, zones_id=?", [$multiselect[$x][0], $multiselect[$x][1], self::$zones_id]);
                }
            }

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
       self::$count = 0;
        
        self::$countries_multiselect_temp = \eMarket\Core\Pdo::getColRow("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
        self::$countries_multiselect = array_column(self::$countries_multiselect_temp, 1, 0);
        
        asort(self::$countries_multiselect);
        
        self::$regions_multiselect = \eMarket\Core\Pdo::getColAssoc("SELECT id, country_id, name, region_code  FROM " . TABLE_REGIONS . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$regions = \eMarket\Core\Pdo::getColAssoc("SELECT country_id, regions_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);

        self::$sql_data = \eMarket\Core\Pdo::getColRow("SELECT country_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [self::$zones_id]);
        self::$lines = array_values(array_unique(self::$sql_data, SORT_REGULAR));
        \eMarket\Core\Pages::table(self::$lines);
    }

    /**
     * Tooltip data
     *
     */
    public function tooltip() {
        self::$text_arr = [];
        
        for ($y = \eMarket\Core\Pages::$start; $y < \eMarket\Core\Pages::$finish; $y++) {
            $text = '| ';
            for ($x = 0; $x < count(self::$regions); $x++) {
                if (isset(self::$regions[$x]['country_id']) && isset(self::$lines[$y][0]) && self::$regions[$x]['country_id'] == self::$lines[$y][0]) {
                    $text .= \eMarket\Core\Func::filterArrayToKeyAssoc(self::$regions_multiselect, 'country_id', self::$regions[$x]['country_id'], 'name', 'id')[self::$regions[$x]['regions_id']] . ' | ';
                }
            }
            array_push(self::$text_arr, $text);
        }
    }

}
