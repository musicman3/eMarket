<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

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
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Login {

    public static $routing_parameter = 'login';

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
    private function activationCode(): void {
        if (Valid::inGET('activation_code')) {
            $id_actvation = Pdo::getValue("SELECT id FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE activation_code=?", [Valid::inGET('activation_code')]);
            if ($id_actvation != NULL) {
                $account_date = Pdo::getValue("SELECT UNIX_TIMESTAMP (date_account_created) FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
                if ($account_date + (3 * 24 * 60 * 60) > time()) {
                    Pdo::action("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
                    Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [1, $id_actvation]);
                    Messages::alert('messages_activation_complete', 'success', lang('messages_activation_complete'), 7000, true);
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
    private function passwordRecovery(): void {
        if (Valid::inPOST('email_for_recovery')) {
            $customer_id = Pdo::getValue("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [Valid::inPOST('email_for_recovery')]);
            $recovery_check = Pdo::getValue("SELECT recovery_code FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            if ($customer_id != FALSE && $recovery_check == FALSE) {
                $recovery_code = Func::getToken(64);
                Pdo::action("INSERT INTO " . TABLE_PASSWORD_RECOVERY . " SET customer_id=?, recovery_code=?, recovery_code_created=?", [$customer_id, $recovery_code, date("Y-m-d H:i:s")]);

                $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
                Messages::sendMail(Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

                Messages::alert('register_password_recovery_message_success', 'success', lang('register_password_recovery_message_success'), 7000, true);
            } elseif ($customer_id != FALSE && $recovery_check != FALSE) {
                $recovery_code = Func::getToken(64);
                Pdo::action("UPDATE " . TABLE_PASSWORD_RECOVERY . " SET recovery_code=?, recovery_code_created=? WHERE customer_id=?", [$recovery_code, date("Y-m-d H:i:s"), $customer_id]);

                $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
                Messages::sendMail(Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

                Messages::alert('register_password_recovery_message_success', 'success', lang('register_password_recovery_message_success'), 7000, true);
            } else {
                Messages::alert('register_password_recovery_message_failed', 'danger', lang('register_password_recovery_message_failed'), 7000, true);
            }
        }
    }

    /**
     * Logout
     *
     */
    private function logout(): void {
        if (Valid::inGET('logout')) {
            unset($_SESSION['customer_password']);
            unset($_SESSION['customer_email']);
            header('Location: ?route=' . Valid::inGET('route'));
            exit;
        }
    }

    /**
     * Entry
     *
     */
    private function entry(): void {
        if (Valid::inPOST('email')) {
            $HASH = (string) Pdo::getValue("SELECT password FROM " . TABLE_CUSTOMERS . " WHERE email=?", [Valid::inPOST('email')]);
            if (!password_verify(Valid::inPOST('password'), $HASH)) {
                Messages::alert('messages_email_or_password_is_not_correct', 'danger', lang('messages_email_or_password_is_not_correct'), 7000, true);
            } else {
                $_SESSION['customer_password'] = $HASH;
                $_SESSION['customer_email'] = Valid::inPOST('email');
                unset($_SESSION['without_registration_data']);
                unset($_SESSION['without_registration_user']);
                if (Valid::inGET('redirect') == 'cart') {
                    header('Location: ?route=cart');
                    exit;
                } else {
                    header('Location: ' . HTTP_SERVER);
                    exit;
                }
            }
        }
    }

}
