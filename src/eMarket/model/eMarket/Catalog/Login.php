<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Clock\SystemClock,
    Cryptography,
    Messages,
    Valid
};
use Cruder\Db;

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
    public $title = 'title_login_index';

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

            $id_actvation = Db::connect()
                    ->read(TABLE_CUSTOMERS_ACTIVATION)
                    ->selectValue('id')
                    ->where('activation_code=', Valid::inGET('activation_code'))
                    ->save();

            if ($id_actvation != NULL) {

                $id_actvation = Db::connect()
                        ->read(TABLE_CUSTOMERS)
                        ->selectValue('{{UNIX_TIMESTAMP->date_account_created}}')
                        ->where('id=', $id_actvation)
                        ->save();

                if ($account_date + (3 * 24 * 60 * 60) > SystemClock::nowUnixTime()) {

                    Db::connect()
                            ->delete(TABLE_CUSTOMERS_ACTIVATION)
                            ->where('id=', $id_actvation)
                            ->save();

                    Db::connect()
                            ->update(TABLE_CUSTOMERS)
                            ->set('status', 1)
                            ->where('id=', $id_actvation)
                            ->save();

                    Messages::alert('messages_activation_complete', 'success', lang('messages_activation_complete'), 7000, true);
                } else {

                    Db::connect()
                            ->delete(TABLE_CUSTOMERS_ACTIVATION)
                            ->where('id=', $id_actvation)
                            ->save();

                    Db::connect()
                            ->delete(TABLE_CUSTOMERS)
                            ->where('id=', $id_actvation)
                            ->save();
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

            $customer_id = Db::connect()
                    ->read(TABLE_CUSTOMERS)
                    ->selectValue('id')
                    ->where('email=', Valid::inPOST('email_for_recovery'))
                    ->save();

            $recovery_check = Db::connect()
                    ->read(TABLE_PASSWORD_RECOVERY)
                    ->selectValue('recovery_code')
                    ->where('customer_id=', $customer_id)
                    ->save();

            if ($customer_id != FALSE && $recovery_check == FALSE) {
                $recovery_code = Cryptography::getToken(64);

                Db::connect()
                        ->create(TABLE_PASSWORD_RECOVERY)
                        ->set('customer_id', $customer_id)
                        ->set('recovery_code', $recovery_code)
                        ->set('recovery_code_created', SystemClock::nowSqlDateTime())
                        ->save();

                $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
                Messages::sendMail(Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

                Messages::alert('register_password_recovery_message_success', 'success', lang('register_password_recovery_message_success'), 7000, true);
            } elseif ($customer_id != FALSE && $recovery_check != FALSE) {
                $recovery_code = Cryptography::getToken(64);

                Db::connect()
                        ->update(TABLE_PASSWORD_RECOVERY)
                        ->set('recovery_code', $recovery_code)
                        ->set('recovery_code_created', SystemClock::nowSqlDateTime())
                        ->where('customer_id=', $customer_id)
                        ->save();

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

            $HASH = (string) Db::connect()
                            ->read(TABLE_CUSTOMERS)
                            ->selectValue('password')
                            ->where('email=', Valid::inPOST('email'))
                            ->save();

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
