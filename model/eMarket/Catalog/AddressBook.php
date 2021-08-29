<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use eMarket\Core\{
    Autorize,
    Messages,
    Pdo,
    Valid
};

/**
 * Address Book
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class AddressBook {

    public static $regions_data;
    public static $address_data_json = FALSE;
    public static $countries_data_json = FALSE;
    public static $address_data;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->autorize();
        $this->jsonEcho();
        $this->initData();
        $this->add();
        $this->edit();
        $this->delete();
        $this->data();
    }

    /**
     * Autorize
     *
     */
    public function autorize() {
        if (Autorize::$customer == FALSE) {
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Json Echo
     *
     */
    public function jsonEcho() {
        if (Valid::inPostJson('countries_select')) {
            self::$regions_data = Pdo::getColAssoc("SELECT * FROM " . TABLE_REGIONS . " WHERE language=? AND country_id=? ORDER BY name ASC", [
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
    public function initData() {
        $countries_array = Pdo::getColAssoc("SELECT * FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY name ASC", [lang('#lang_all')[0]]);
        self::$countries_data_json = json_encode($countries_array);

        self::$address_data_json = Pdo::getCell("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);

        if (self::$address_data_json == FALSE) {
            self::$address_data = [];
            self::$address_data_json = json_encode([]);
        } else {
            self::$address_data = json_decode(self::$address_data_json, 1);
        }
    }

    /**
     * Add
     *
     */
    public function add() {
        if (Valid::inPOST('add')) {
            if (Valid::inPOST('default')) {
                $default = 1;
            } else {
                $default = 0;
            }

            $address_array = ['countries_id' => Valid::inPOST('countries'),
                'regions_id' => Valid::inPOST('regions'),
                'city' => Valid::inPOST('city'),
                'zip' => Valid::inPOST('zip'),
                'address' => Valid::inPOST('address'),
                'default' => $default];

            $x = 0;
            foreach (self::$address_data as $data) {
                if ($data['default'] == 1 && $default == 1) {
                    $address_data[$x]['default'] = 0;
                }
                $x++;
            }
            array_unshift(self::$address_data, $address_array);

            Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET address_book=? WHERE email=?", [json_encode(self::$address_data), $_SESSION['email_customer']]);

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (Valid::inPOST('edit')) {
            if (Valid::inPOST('default')) {
                $default = 1;
            } else {
                $default = 0;
            }

            $address_array = ['countries_id' => Valid::inPOST('countries'),
                'regions_id' => Valid::inPOST('regions'),
                'city' => Valid::inPOST('city'),
                'zip' => Valid::inPOST('zip'),
                'address' => Valid::inPOST('address'),
                'default' => $default];

            $x = 0;
            foreach (self::$address_data as $data) {
                if ($data['default'] == 1 && $default == 1) {
                    self::$address_data[$x]['default'] = 0;
                }
                $x++;
            }

            self::$address_data[(int) Valid::inPOST('edit') - 1] = $address_array;

            Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET address_book=? WHERE email=?", [json_encode(self::$address_data), $_SESSION['email_customer']]);

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (Valid::inPOST('delete')) {

            $number = (int) Valid::inPOST('delete') - 1;
            if (self::$address_data[$number]['default'] == 1 && count(self::$address_data) > 1) {
                unset(self::$address_data[$number]);
                $address_data_out = array_values(self::$address_data);
                $address_data_out[0]['default'] = 1;
            } else {
                unset(self::$address_data[$number]);
                $address_data_out = array_values(self::$address_data);
            }

            if (count($address_data_out) == 0) {
                $address_data_out_table = NULL;
            } else {
                $address_data_out_table = json_encode($address_data_out);
            }

            Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET address_book=? WHERE email=?", [$address_data_out_table, $_SESSION['email_customer']]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        $x = 0;
        foreach (self::$address_data as $address_val) {
            $countries_array = Pdo::getColAssoc("SELECT * FROM " . TABLE_COUNTRIES . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['countries_id']])[0];
            $regions_array = Pdo::getColAssoc("SELECT id, name FROM " . TABLE_REGIONS . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['regions_id']])[0];
            if ($address_val['countries_id'] == $countries_array['id']) {
                self::$address_data[$x]['countries_name'] = $countries_array['name'];
                self::$address_data[$x]['alpha_2'] = $countries_array['alpha_2'];
                self::$address_data[$x]['regions_name'] = $regions_array['name'];
            }
            $x++;
        }
    }

}
