<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Middleware\CatalogAuthorize,
    Cryptography,
    Messages
};
use R2D2\R2\Valid;
use Cruder\Db;

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
    public static $middleware = ' CurrencyCheck, CatalogAuthorize';
    public $title = 'title_my_account_index';

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
        if (CatalogAuthorize::$customer == FALSE) {
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
                $password_hash = Cryptography::passwordHash(Valid::inPOST('password'));

                Db::connect()
                        ->update(TABLE_CUSTOMERS)
                        ->set('firstname', Valid::inPOST('firstname'))
                        ->set('lastname', Valid::inPOST('lastname'))
                        ->set('middle_name', Valid::inPOST('middle_name'))
                        ->set('telephone', Valid::inPOST('telephone'))
                        ->set('password', $password_hash)
                        ->where('email=', CatalogAuthorize::$customer['email'])
                        ->save();
            } else {

                Db::connect()
                        ->update(TABLE_CUSTOMERS)
                        ->set('firstname', Valid::inPOST('firstname'))
                        ->set('lastname', Valid::inPOST('lastname'))
                        ->set('middle_name', Valid::inPOST('middle_name'))
                        ->set('telephone', Valid::inPOST('telephone'))
                        ->where('email=', CatalogAuthorize::$customer['email'])
                        ->save();
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }
}
