<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Authorize,
    Pdo,
    Valid
};

/**
 * Checkout
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
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
        $this->authorize();
        $this->customerData();
        $this->customerAddress();
    }

    /**
     * Authorize
     *
     */
    public function authorize(): void {
        if (Authorize::$customer == FALSE) {
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Customer Data
     *
     */
    public function customerData(): void {
        self::$customer = Pdo::getAssoc("SELECT id, address_book, gender, firstname, lastname, middle_name, fax, telephone FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    }

    /**
     * Customer Address
     *
     */
    public function customerAddress(): void {
        if (Valid::inPOST('address')){
        $address_all = json_decode(self::$customer['address_book'], true);
        self::$address_data = $address_all[Valid::inPOST('address') - 1];
        }
    }

}
