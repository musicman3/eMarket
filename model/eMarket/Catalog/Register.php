<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use eMarket\Core\{
    Authorize,
    Func,
    Messages,
    Pdo,
    Settings,
    Valid
};

/**
 * Register
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
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
        if (Valid::inPOST('email')) {

            self::$user_email = Pdo::getValue("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [Valid::inPOST('email')]);
            if (self::$user_email == NULL) {
                $password_hash = Authorize::passwordHash(Valid::inPOST('password'));
                Pdo::action("INSERT INTO " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, date_account_created=?, email=?, telephone=?, ip_address=?, password=?", [
                    Valid::inPOST('firstname'), Valid::inPOST('lastname'), date("Y-m-d H:i:s"),
                    Valid::inPOST('email'), Valid::inPOST('telephone'),
                    Settings::ipAddress(), $password_hash
                ]);

                $id = Pdo::lastInsertId();
                $activation_code = Func::getToken(64);
                Pdo::action("INSERT INTO " . TABLE_CUSTOMERS_ACTIVATION . " SET id=?, activation_code=?", [$id, $activation_code]);

                $link = HTTP_SERVER . '?route=login&activation_code=' . $activation_code;
                Messages::sendMail(Valid::inPOST('email'), lang('email_registration_subject'), sprintf(lang('email_registration_message'), $link, $link));

                Messages::alert('messages_registration_complete', 'success', lang('messages_registration_complete'), 7000, true);
            } else {
                Messages::alert('messages_email_is_busy', 'danger', lang('messages_email_is_busy'), 7000, true);
            }
        }
    }

}
