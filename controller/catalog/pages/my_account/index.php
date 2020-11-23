<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if ($CUSTOMER == FALSE) {
    header('Location: ?route=login'); // переадресация на LOGIN
    exit;
}

if (\eMarket\Valid::inPOST('edit')) {
    if (\eMarket\Valid::inPOST('password') && \eMarket\Valid::inPOST('confirm_password') && \eMarket\Valid::inPOST('password') == \eMarket\Valid::inPOST('confirm_password')) {
        $password_hash = \eMarket\Autorize::passwordHash(\eMarket\Valid::inPOST('password'));
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, middle_name=?, telephone=?, password=? WHERE email=?", [\eMarket\Valid::inPOST('firstname'), \eMarket\Valid::inPOST('lastname'), \eMarket\Valid::inPOST('middle_name'), \eMarket\Valid::inPOST('telephone'), $password_hash, $CUSTOMER['email']]);
    } else {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET firstname=?, lastname=?, middle_name=?, telephone=? WHERE email=?", [\eMarket\Valid::inPOST('firstname'), \eMarket\Valid::inPOST('lastname'), \eMarket\Valid::inPOST('middle_name'), \eMarket\Valid::inPOST('telephone'), $CUSTOMER['email']]);
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>