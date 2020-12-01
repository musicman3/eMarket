<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inGET('activation_code')) {
    $id_actvation = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE activation_code=?", [\eMarket\Valid::inGET('activation_code')]);
    if ($id_actvation != NULL) {
        $account_date = \eMarket\Pdo::selectPrepare("SELECT UNIX_TIMESTAMP (date_account_created) FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
        // Если дата активации не истекла
        if ($account_date + (3 * 24 * 60 * 60) > time()) {
            \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [1, $id_actvation]);
            \eMarket\Messages::alert('success', lang('messages_activation_complete'), 7000, true);
        } else {
            \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
            \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
        }
    }
}

if (\eMarket\Valid::inPOST('email_for_recovery')) {
    $customer_id = \eMarket\Pdo::getCellFalse("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [\eMarket\Valid::inPOST('email_for_recovery')]);
    $recovery_check = \eMarket\Pdo::getCellFalse("SELECT recovery_code FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
    if ($customer_id != FALSE && $recovery_check == FALSE) { // Если произведен запрос на восстановление доступа
        $recovery_code = \eMarket\Func::getToken(64);
        \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_PASSWORD_RECOVERY . " SET customer_id=?, recovery_code=?, recovery_code_created=?", [$customer_id, $recovery_code, date("Y-m-d H:i:s")]);

        $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
        \eMarket\Messages::sendMail(\eMarket\Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

        \eMarket\Messages::alert('success', lang('register_password_recovery_message_success'), 7000, true);
    } elseif ($customer_id != FALSE && $recovery_check != FALSE) { // Если произведен повторный запрос
        $recovery_code = \eMarket\Func::getToken(64);
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_PASSWORD_RECOVERY . " SET recovery_code=?, recovery_code_created=? WHERE customer_id=?", [$recovery_code, date("Y-m-d H:i:s"), $customer_id]);

        $link = HTTP_SERVER . '?route=recoverypass&recovery_code=' . $recovery_code;
        \eMarket\Messages::sendMail(\eMarket\Valid::inPOST('email_for_recovery'), lang('email_recovery_password_subject'), sprintf(lang('email_recovery_password_message'), $link, $link));

        \eMarket\Messages::alert('success', lang('register_password_recovery_message_success'), 7000, true);
    } else { // Если нет такого пользователя
        \eMarket\Messages::alert('danger', lang('register_password_recovery_message_failed'), 7000, true);
    }
}

if (\eMarket\Valid::inGET('logout')) {
    unset($_SESSION['password_customer']);
    unset($_SESSION['email_customer']);
    header('Location: ?route=' . \eMarket\Valid::inGET('route'));
}

if (\eMarket\Valid::inPOST('email')) {
    $HASH = \eMarket\Pdo::selectPrepare("SELECT password FROM " . TABLE_CUSTOMERS . " WHERE email=?", [\eMarket\Valid::inPOST('email')]);
    if (!password_verify(\eMarket\Valid::inPOST('password'), $HASH)) {
        \eMarket\Messages::alert('danger', lang('messages_email_or_password_is_not_correct'), 7000, true);
    } else {
        $_SESSION['password_customer'] = $HASH;
        $_SESSION['email_customer'] = \eMarket\Valid::inPOST('email');
        if (\eMarket\Valid::inGET('redirect') == 'cart') {
            header('Location: ?route=cart');
        } else {
            header('Location: ' . HTTP_SERVER);
        }
    }
}
?>