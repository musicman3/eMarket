<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

/**
 * Register
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class Register {
    
    public static $user_email = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->init();
    }

    /**
     * Init
     *
     */
    public function init() {
        if (\eMarket\Core\Valid::inPOST('email')) {

            self::$user_email = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [\eMarket\Core\Valid::inPOST('email')]);
            if (self::$user_email == NULL) {
                $password_hash = \eMarket\Core\Autorize::passwordHash(\eMarket\Core\Valid::inPOST('password'));
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, date_account_created=?, email=?, telephone=?, ip_address=?, password=?", [\eMarket\Core\Valid::inPOST('firstname'), \eMarket\Core\Valid::inPOST('lastname'), date("Y-m-d H:i:s"), \eMarket\Core\Valid::inPOST('email'), \eMarket\Core\Valid::inPOST('telephone'), \eMarket\Core\Settings::ipAddress(), $password_hash]);

                $id = \eMarket\Core\Pdo::lastInsertId();
                $activation_code = \eMarket\Core\Func::getToken(64);
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_CUSTOMERS_ACTIVATION . " SET id=?, activation_code=?", [$id, $activation_code]);

                $link = HTTP_SERVER . '?route=login&activation_code=' . $activation_code;
                \eMarket\Core\Messages::sendMail(\eMarket\Core\Valid::inPOST('email'), lang('email_registration_subject'), sprintf(lang('email_registration_message'), $link, $link));

                \eMarket\Core\Messages::alert('success', lang('messages_registration_complete'), 7000, true);
            } else {
                \eMarket\Core\Messages::alert('danger', lang('messages_email_is_busy'), 7000, true);
            }
        }
    }

}
