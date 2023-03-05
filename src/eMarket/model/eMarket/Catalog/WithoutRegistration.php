<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Pdo,
    Valid
};

/**
 * WithoutRegistration
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class WithoutRegistration {

    public static $regions_data;
    public static $address_data_json = FALSE;
    public static $countries_data_json = FALSE;
    public static $address_data;
    public static $without_registration_data;
    public static $without_registration_user;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->jsonEcho();
        $this->initData();
        $this->sessionData();
        $this->data();
    }

    /**
     * Json Echo
     *
     */
    public function jsonEcho(): void {
        if (Valid::inPostJson('countries_select')) {
            self::$regions_data = Pdo::getAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE language=? AND country_id=? ORDER BY name ASC", [
                        lang('#lang_all')[0], Valid::inPostJson('countries_select')
            ]);
            echo json_encode(self::$regions_data);
            exit;
        }
    }

    /**
     * Init Data
     *
     */
    public function initData(): void {
        $countries_array = Pdo::getAssoc("SELECT * FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY name ASC", [lang('#lang_all')[0]]);
        self::$countries_data_json = json_encode($countries_array);
        self::$address_data = [];
        self::$address_data_json = json_encode([]);

        if (isset($_SESSION['without_registration_data']) && isset($_SESSION['without_registration_user'])) {
            self::$without_registration_data = $_SESSION['without_registration_data'];
            self::$without_registration_user = $_SESSION['without_registration_user'];
        } else {
            self::$without_registration_data = json_encode([]);
            self::$without_registration_user = json_encode([]);
        }
    }

    /**
     * Session Data
     *
     */
    public function sessionData(): void {
        if (Valid::inPOST('firstname') && Valid::inPOST('lastname') && Valid::inPOST('telephone') && Valid::inPOST('countries') && Valid::inPOST('regions') && Valid::inPOST('city') && Valid::inPOST('zip') && Valid::inPOST('address')) {

            $_SESSION['without_registration_data'] = json_encode([[
            'countries_id' => Valid::inPOST('countries'),
            'regions_id' => Valid::inPOST('regions'),
            'city' => Valid::inPOST('city'),
            'zip' => Valid::inPOST('zip'),
            'address' => Valid::inPOST('address'),
            'default' => ''
            ]]);

            $_SESSION['without_registration_user'] = json_encode([[
            'firstname' => Valid::inPOST('firstname'),
            'lastname' => Valid::inPOST('lastname'),
            'telephone' => Valid::inPOST('telephone')
            ]]);

            if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
                header('Location: ?route=catalog');
            } else {
                header('Location: ?route=cart');
            }
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $x = 0;
        foreach (self::$address_data as $address_val) {
            $countries_array = Pdo::getAssoc("SELECT * FROM " . TABLE_COUNTRIES . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['countries_id']])[0];
            $regions_array = Pdo::getAssoc("SELECT id, name FROM " . TABLE_REGIONS . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['regions_id']])[0];
            if ($address_val['countries_id'] == $countries_array['id']) {
                self::$address_data[$x]['countries_name'] = $countries_array['name'];
                self::$address_data[$x]['alpha_2'] = $countries_array['alpha_2'];
                self::$address_data[$x]['regions_name'] = $regions_array['name'];
            }
            $x++;
        }
    }

}
