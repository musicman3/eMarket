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
 * Recovery Password
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class RecoveryPass {

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
    public function recovery() {
        if (Valid::inGET('recovery_code')) {
            self::$customer_id = Pdo::getCellFalse("SELECT customer_id FROM " . TABLE_PASSWORD_RECOVERY . " WHERE recovery_code=?", [
                        Valid::inGET('recovery_code')]
            );
            if (self::$customer_id != FALSE && Valid::inPOST('password')) {
                $recovery_code_created = Pdo::selectPrepare("SELECT UNIX_TIMESTAMP (recovery_code_created) FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [
                            self::$customer_id
                ]);
                if ($recovery_code_created + (3 * 24 * 60 * 60) > time()) {
                    Pdo::action("DELETE FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [self::$customer_id]);

                    $password_hash = Autorize::passwordHash(Valid::inPOST('password'));
                    Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET password=? WHERE id=?", [$password_hash, self::$customer_id]);
                    Messages::alert('messages_recovery_password_complete', 'success', lang('messages_recovery_password_complete'), 7000, true);
                } else {
                    Pdo::action("DELETE FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [self::$customer_id]);
                    Messages::alert('messages_recovery_password_failed', 'danger', lang('messages_recovery_password_failed'), 7000, true);
                }
            }
        }
    }

}
