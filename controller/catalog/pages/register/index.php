<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Core\Valid::inPOST('email')) {

    $user_email = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE email=?", [\eMarket\Core\Valid::inPOST('email')]);
    if ($user_email == NULL) {
        $password_hash = \eMarket\Core\Autorize::passwordHash(\eMarket\Core\Valid::inPOST('password'));
        \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, date_account_created=?, email=?, telephone=?, ip_address=?, password=?", [\eMarket\Core\Valid::inPOST('firstname'), \eMarket\Core\Valid::inPOST('lastname'), date("Y-m-d H:i:s"), \eMarket\Core\Valid::inPOST('email'), \eMarket\Core\Valid::inPOST('telephone'), \eMarket\Core\Set::ipAdress(), $password_hash]);
        
        $id = \eMarket\Core\Pdo::lastInsertId();
        $activation_code = $FUNC->getToken(64);
        \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_CUSTOMERS_ACTIVATION . " SET id=?, activation_code=?", [$id, $activation_code]);
        
        $link = HTTP_SERVER . '?route=login&activation_code=' . $activation_code;
        \eMarket\Other\Messages::sendMail(\eMarket\Core\Valid::inPOST('email'), lang('email_registration_subject'), sprintf(lang('email_registration_message'), $link, $link));
        
        $_SESSION['message'] = ['success', lang('messages_registration_complete'), 7000, TRUE];
    } else {
        $_SESSION['message'] = ['danger', lang('messages_email_is_busy'), 7000, TRUE];
    }
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>