<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

/**
 * My Account
 *
 * @package Catalog
 * @author eMarket
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
        if (\eMarket\Core\Autorize::$CUSTOMER == FALSE) {
            header('Location: ?route=login');
            exit;
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (\eMarket\Core\Valid::inPOST('edit')) {
            if (\eMarket\Core\Valid::inPOST('password') && \eMarket\Core\Valid::inPOST('confirm_password') && \eMarket\Core\Valid::inPOST('password') == \eMarket\Core\Valid::inPOST('confirm_password')) {
                $password_hash = \eMarket\Core\Autorize::passwordHash(\eMarket\Core\Valid::inPOST('password'));
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, middle_name=?, telephone=?, password=? WHERE email=?", [\eMarket\Core\Valid::inPOST('firstname'), \eMarket\Core\Valid::inPOST('lastname'), \eMarket\Core\Valid::inPOST('middle_name'), \eMarket\Core\Valid::inPOST('telephone'), $password_hash, \eMarket\Core\Autorize::$CUSTOMER['email']]);
            } else {
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, middle_name=?, telephone=? WHERE email=?", [\eMarket\Core\Valid::inPOST('firstname'), \eMarket\Core\Valid::inPOST('lastname'), \eMarket\Core\Valid::inPOST('middle_name'), \eMarket\Core\Valid::inPOST('telephone'), \eMarket\Core\Autorize::$CUSTOMER['email']]);
            }

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

}
