<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use eMarket\Core\{
    Autorize,
    Pdo,
    Valid
};

/**
 * Checkout
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class Checkout {

    public static $customer;
    public static $address_data;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->autorize();
        self::customerData();
        self::customerAddress();
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
     * Customer Data
     *
     */
    static function customerData() {
        self::$customer = Pdo::getColAssoc("SELECT id, address_book, gender, firstname, lastname, middle_name, fax, telephone FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    }

    /**
     * Customer Address
     *
     */
    static function customerAddress() {
        if (Valid::inPOST('address')){
        $address_all = json_decode(self::$customer['address_book'], 1);
        self::$address_data = $address_all[Valid::inPOST('address') - 1];
        }
    }

}
