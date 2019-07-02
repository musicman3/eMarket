<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if ($VALID->inPOST('email')) {

    $user_email = $PDO->selectPrepare("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$VALID->inPOST('email')]);
    if ($user_email == NULL) {
        $password_hash = $AUTORIZE->passwordHash($VALID->inPOST('password'));
        $PDO->inPrepare("INSERT INTO " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, date_account_created=?, email=?, telephone=?, ip_address=?, password=?", [$VALID->inPOST('firstname'), $VALID->inPOST('lastname'), date("Y-m-d H:i:s"), $VALID->inPOST('email'), $VALID->inPOST('telephone'), $SET->ipAdress(), $password_hash]);
        
        $id = $PDO->lastInsertId();
        $activation_code = $FUNC->getToken(64);
        $PDO->inPrepare("INSERT INTO " . TABLE_CUSTOMERS_ACTIVATION . " SET id=?, activation_code=?", [$id, $activation_code]);
        
        $link = HTTP_SERVER . '?route=login&activation_code=' . $activation_code;
        $MESSAGES->sendMail($VALID->inPOST('email'), lang('email_registration_subject'), sprintf(lang('email_registration_message'), $link, $link));
        
        $_SESSION['message'] = ['success', lang('messages_registration_complete'), 7000, TRUE];
    } else {
        $_SESSION['message'] = ['danger', lang('messages_email_is_busy'), 7000, TRUE];
    }
}

if ($VALID->inPOST('email_for_recovery')) {
    $recovery = $PDO->getCellFalse("SELECT email FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$VALID->inPOST('email_for_recovery')]);
    if ($recovery != FALSE) {
        $_SESSION['message'] = ['success', lang('password_recovery_message_success'), 7000, TRUE];
    } else {
        $_SESSION['message'] = ['danger', lang('password_recovery_message_failed'), 7000, TRUE];
    }
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>