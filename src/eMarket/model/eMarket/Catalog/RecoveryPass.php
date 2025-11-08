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
    Messages
};
use R2D2\R2\Valid;
use Cruder\Db;

/**
 * Recovery Password
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class RecoveryPass {

    public static $routing_parameter = 'recoverypass';
    public static $middleware = 'CurrencyCheck, CatalogAuthorize';
    public $title = 'title_recoverypass_index';
    public static $customer_id;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->recovery();
    }

    /**
     * Recovery
     *
     */
    private function recovery(): void {
        if (Valid::inGET('recovery_code')) {

            self::$customer_id = Db::connect()
                    ->read(TABLE_PASSWORD_RECOVERY)
                    ->selectValue('customer_id')
                    ->where('recovery_code=', Valid::inGET('recovery_code'))
                    ->save();

            if (self::$customer_id != FALSE && Valid::inPOST('password')) {

                $recovery_code_created = Db::connect()
                        ->read(TABLE_PASSWORD_RECOVERY)
                        ->selectValue('{{UNIX_TIMESTAMP->recovery_code_created}}')
                        ->where('customer_id=', self::$customer_id)
                        ->save();

                if ($recovery_code_created + (3 * 24 * 60 * 60) > SystemClock::nowUnixTime()) {

                    Db::connect()
                            ->delete(TABLE_PASSWORD_RECOVERY)
                            ->where('customer_id=', self::$customer_id)
                            ->save();

                    $password_hash = Cryptography::passwordHash(Valid::inPOST('password'));

                    Db::connect()
                            ->update(TABLE_CUSTOMERS)
                            ->set('password', $password_hash)
                            ->where('id=', self::$customer_id)
                            ->save();

                    Messages::alert('messages_recovery_password_complete', 'success', lang('messages_recovery_password_complete'), 7000, true);
                } else {

                    Db::connect()
                            ->delete(TABLE_PASSWORD_RECOVERY)
                            ->where('customer_id=', self::$customer_id)
                            ->save();

                    Messages::alert('messages_recovery_password_failed', 'danger', lang('messages_recovery_password_failed'), 7000, true);
                }
            }
        }
    }
}
