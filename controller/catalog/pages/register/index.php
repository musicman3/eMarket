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
        $MESSAGES->sendMail($VALID->inPOST('email'));
    } else {
        $_SESSION['message'] = ['danger', lang('messages_email_is_busy'), 7000, TRUE];
    }
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>