<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

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
        $this->login();
        $this->entry();
    }

    /**
     * Activation Code
     *
     */
    public function activationCode() {
        if (\eMarket\Core\Valid::inGET('activation_code')) {
            $id_actvation = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE activation_code=?", [\eMarket\Core\Valid::inGET('activation_code')]);
            if ($id_actvation != NULL) {
                $account_date = \eMarket\Core\Pdo::selectPrepare("SELECT UNIX_TIMESTAMP (date_account_created) FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
                if ($account_date + (3 * 24 * 60 * 60) > time()) {
                    \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
                    \eMarket\Core\Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [1, $id_actvation]);
                    \eMarket\Core\Messages::alert('success', lang('messages_activation_complete'), 7000, true);
                } else {
                    \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
                    \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
                }
            }
        }
    }

    /**
     * Password Recovery
     *
     */
    public function passwordRecovery() {
        if (\eMarket\Core\Valid::inPOST('email_for_recovery')) {
            $customer_id = \eMarket\Core\Pdo::getCellFalse("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [\eMarket\Core\Valid::inPOST('email_for_recovery')]);
            $recovery_check = \eMarket\Core\Pdo::getCellFalse("SELECT recovery_code FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            if ($customer_id != FALSE && $recovery_check == FALSE) {
                $recovery_code = \eMarket\Core\Func::getToken(64);
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_PASSWORD_RECOVERY . " SET customer_id=?, recovery_code=?, recovery_code_created=?", [$customer_id, $recovery_code, date("Y-m-d H:i:s")]);

                $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
                \eMarket\Core\Messages::sendMail(\eMarket\Core\Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

                \eMarket\Core\Messages::alert('success', lang('register_password_recovery_message_success'), 7000, true);
            } elseif ($customer_id != FALSE && $recovery_check != FALSE) {
                $recovery_code = \eMarket\Core\Func::getToken(64);
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_PASSWORD_RECOVERY . " SET recovery_code=?, recovery_code_created=? WHERE customer_id=?", [$recovery_code, date("Y-m-d H:i:s"), $customer_id]);

                $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
                \eMarket\Core\Messages::sendMail(\eMarket\Core\Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

                \eMarket\Core\Messages::alert('success', lang('register_password_recovery_message_success'), 7000, true);
            } else {
                \eMarket\Core\Messages::alert('danger', lang('register_password_recovery_message_failed'), 7000, true);
            }
        }
    }

    /**
     * Login
     *
     */
    public function login() {
        if (\eMarket\Core\Valid::inGET('logout')) {
            unset($_SESSION['password_customer']);
            unset($_SESSION['email_customer']);
            header('Location: ?route=' . \eMarket\Core\Valid::inGET('route'));
        }
    }

    /**
     * Entry
     *
     */
    public function entry() {
        if (\eMarket\Core\Valid::inPOST('email')) {
            $HASH = \eMarket\Core\Pdo::selectPrepare("SELECT password FROM " . TABLE_CUSTOMERS . " WHERE email=?", [\eMarket\Core\Valid::inPOST('email')]);
            if (!password_verify(\eMarket\Core\Valid::inPOST('password'), $HASH)) {
                \eMarket\Core\Messages::alert('danger', lang('messages_email_or_password_is_not_correct'), 7000, true);
            } else {
                $_SESSION['password_customer'] = $HASH;
                $_SESSION['email_customer'] = \eMarket\Core\Valid::inPOST('email');
                if (\eMarket\Core\Valid::inGET('redirect') == 'cart') {
                    header('Location: ?route=cart');
                } else {
                    header('Location: ' . HTTP_SERVER);
                }
            }
        }
    }

}
