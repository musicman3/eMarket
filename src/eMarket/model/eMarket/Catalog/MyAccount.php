<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Authorize,
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

    public static $routing_parameter = 'my_account';

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->authorize();
        $this->edit();
    }

    /**
     * Authorize
     *
     */
    private function authorize(): void {
        if (Authorize::$customer == FALSE) {
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Edit
     *
     */
    private function edit(): void {
        if (Valid::inPOST('edit')) {
            if (Valid::inPOST('password') && Valid::inPOST('confirm_password') && Valid::inPOST('password') == Valid::inPOST('confirm_password')) {
                $password_hash = Authorize::passwordHash(Valid::inPOST('password'));
                Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, middle_name=?, telephone=?, password=? WHERE email=?", [
                    Valid::inPOST('firstname'), Valid::inPOST('lastname'),
                    Valid::inPOST('middle_name'), Valid::inPOST('telephone'), $password_hash,
                    Authorize::$customer['email']
                ]);
            } else {
                Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, middle_name=?, telephone=? WHERE email=?", [
                    Valid::inPOST('firstname'), Valid::inPOST('lastname'),
                    Valid::inPOST('middle_name'), Valid::inPOST('telephone'),
                    Authorize::$customer['email']
                ]);
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

}
