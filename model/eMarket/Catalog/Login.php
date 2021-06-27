<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use eMarket\Core\{
    Func,
    Messages,
    Pdo,
    Valid
};

/**
 * Login
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class Login {

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->activationCode();
        $this->passwordRecovery();
        $this->logout();
        $this->entry();
    }

    /**
     * Activation Code
     *
     */
    public function activationCode() {
        if (Valid::inGET('activation_code')) {
            $id_actvation = Pdo::selectPrepare("SELECT id FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE activation_code=?", [Valid::inGET('activation_code')]);
            if ($id_actvation != NULL) {
                $account_date = Pdo::selectPrepare("SELECT UNIX_TIMESTAMP (date_account_created) FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
                if ($account_date + (3 * 24 * 60 * 60) > time()) {
                    Pdo::action("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
                    Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [1, $id_actvation]);
                    Messages::alert('success', lang('messages_activation_complete'), 7000, true);
                } else {
                    Pdo::action("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
                    Pdo::action("DELETE FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
                }
            }
        }
    }

    /**
     * Password Recovery
     *
     */
    public function passwordRecovery() {
        if (Valid::inPOST('email_for_recovery')) {
            $customer_id = Pdo::getCellFalse("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [Valid::inPOST('email_for_recovery')]);
            $recovery_check = Pdo::getCellFalse("SELECT recovery_code FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            if ($customer_id != FALSE && $recovery_check == FALSE) {
                $recovery_code = Func::getToken(64);
                Pdo::action("INSERT INTO " . TABLE_PASSWORD_RECOVERY . " SET customer_id=?, recovery_code=?, recovery_code_created=?", [$customer_id, $recovery_code, date("Y-m-d H:i:s")]);

                $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
                Messages::sendMail(Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

                Messages::alert('success', lang('register_password_recovery_message_success'), 7000, true);
            } elseif ($customer_id != FALSE && $recovery_check != FALSE) {
                $recovery_code = Func::getToken(64);
                Pdo::action("UPDATE " . TABLE_PASSWORD_RECOVERY . " SET recovery_code=?, recovery_code_created=? WHERE customer_id=?", [$recovery_code, date("Y-m-d H:i:s"), $customer_id]);

                $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
                Messages::sendMail(Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

                Messages::alert('success', lang('register_password_recovery_message_success'), 7000, true);
            } else {
                Messages::alert('danger', lang('register_password_recovery_message_failed'), 7000, true);
            }
        }
    }

    /**
     * Logout
     *
     */
    public function logout() {
        if (Valid::inGET('logout')) {
            unset($_SESSION['password_customer']);
            unset($_SESSION['email_customer']);
            header('Location: ?route=' . Valid::inGET('route'));
        }
    }

    /**
     * Entry
     *
     */
    public function entry() {
        if (Valid::inPOST('email')) {
            $HASH = Pdo::selectPrepare("SELECT password FROM " . TABLE_CUSTOMERS . " WHERE email=?", [Valid::inPOST('email')]);
            if (!password_verify(Valid::inPOST('password'), $HASH)) {
                Messages::alert('danger', lang('messages_email_or_password_is_not_correct'), 7000, true);
            } else {
                $_SESSION['password_customer'] = $HASH;
                $_SESSION['email_customer'] = Valid::inPOST('email');
                if (Valid::inGET('redirect') == 'cart') {
                    header('Location: ?route=cart');
                } else {
                    header('Location: ' . HTTP_SERVER);
                }
            }
        }
    }

}
