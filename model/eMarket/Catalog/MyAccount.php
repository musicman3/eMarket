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
 * My Account
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class MyAccount {

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->autorize();
        $this->edit();
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
     * Edit
     *
     */
    public function edit() {
        if (Valid::inPOST('edit')) {
            if (Valid::inPOST('password') && Valid::inPOST('confirm_password') && Valid::inPOST('password') == Valid::inPOST('confirm_password')) {
                $password_hash = Autorize::passwordHash(Valid::inPOST('password'));
                Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, middle_name=?, telephone=?, password=? WHERE email=?", [
                    Valid::inPOST('firstname'), Valid::inPOST('lastname'),
                    Valid::inPOST('middle_name'), Valid::inPOST('telephone'), $password_hash,
                    Autorize::$customer['email']
                ]);
            } else {
                Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, middle_name=?, telephone=? WHERE email=?", [
                    Valid::inPOST('firstname'), Valid::inPOST('lastname'),
                    Valid::inPOST('middle_name'), Valid::inPOST('telephone'),
                    Autorize::$customer['email']
                ]);
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

}
