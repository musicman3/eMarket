<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('email')) {

    $user_email = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [\eMarket\Valid::inPOST('email')]);
    if ($user_email == NULL) {
        $password_hash = \eMarket\Autorize::passwordHash(\eMarket\Valid::inPOST('password'));
        \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, date_account_created=?, email=?, telephone=?, ip_address=?, password=?", [\eMarket\Valid::inPOST('firstname'), \eMarket\Valid::inPOST('lastname'), date("Y-m-d H:i:s"), \eMarket\Valid::inPOST('email'), \eMarket\Valid::inPOST('telephone'), \eMarket\Set::ipAddress(), $password_hash]);
        
        $id = \eMarket\Pdo::lastInsertId();
        $activation_code = \eMarket\Func::getToken(64);
        \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_CUSTOMERS_ACTIVATION . " SET id=?, activation_code=?", [$id, $activation_code]);
        
        $link = HTTP_SERVER . '?route=login&activation_code=' . $activation_code;
        \eMarket\Messages::sendMail(\eMarket\Valid::inPOST('email'), lang('email_registration_subject'), sprintf(lang('email_registration_message'), $link, $link));
        
        \eMarket\Messages::alert('success', lang('messages_registration_complete'), 7000, true);
    } else {
        \eMarket\Messages::alert('danger', lang('messages_email_is_busy'), 7000, true);
    }
}

// Модальное окно
require_once('modal/privacy_policy.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>