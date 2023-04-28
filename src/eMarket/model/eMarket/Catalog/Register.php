<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Cryptography,
    Clock\SystemClock,
    Messages,
    Settings,
    Valid
};
use Cruder\Db;

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

    public static $routing_parameter = 'register';
    public $title = 'title_register_index';
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
    private function init(): void {
        if (Valid::inPOST('email')) {

            self::$user_email = Db::connect()
                    ->read(TABLE_CUSTOMERS)
                    ->selectValue('id')
                    ->where('email=', Valid::inPOST('email'))
                    ->save();

            if (self::$user_email == NULL) {
                $password_hash = Cryptography::passwordHash(Valid::inPOST('password'));

                Db::connect()
                        ->create(TABLE_CUSTOMERS)
                        ->set('firstname', Valid::inPOST('firstname'))
                        ->set('lastname', Valid::inPOST('lastname'))
                        ->set('date_account_created', SystemClock::nowSqlDateTime())
                        ->set('email', Valid::inPOST('email'))
                        ->set('telephone', Valid::inPOST('telephone'))
                        ->set('ip_address', Settings::ipAddress())
                        ->set('password', $password_hash)
                        ->save();

                $id = Db::connect()->lastInsertId()->save();

                $activation_code = Cryptography::getToken(64);

                Db::connect()
                        ->create(TABLE_CUSTOMERS_ACTIVATION)
                        ->set('id', $id)
                        ->set('activation_code', $activation_code)
                        ->save();

                $link = HTTP_SERVER . '?route=login&activation_code=' . $activation_code;
                Messages::sendMail(Valid::inPOST('email'), lang('email_registration_subject'), sprintf(lang('email_registration_message'), $link, $link));

                Messages::alert('messages_registration_complete', 'success', lang('messages_registration_complete'), 7000, true);
            } else {
                Messages::alert('messages_email_is_busy', 'danger', lang('messages_email_is_busy'), 7000, true);
            }
        }
    }

}
