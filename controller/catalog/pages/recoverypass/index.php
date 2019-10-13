<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */


if (\eMarket\Valid::inGET('recovery_code')) {
    $customer_id = \eMarket\Pdo::getCellFalse("SELECT customer_id FROM " . TABLE_PASSWORD_RECOVERY . " WHERE recovery_code=?", [\eMarket\Valid::inGET('recovery_code')]);
    if ($customer_id != FALSE && \eMarket\Valid::inPOST('password')) {
        $recovery_code_created = \eMarket\Pdo::selectPrepare("SELECT UNIX_TIMESTAMP (recovery_code_created) FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
        // Если дата активации не истекла
        if ($recovery_code_created + (3 * 24 * 60 * 60) > time()) {
            \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            
            $password_hash = \eMarket\Autorize::passwordHash(\eMarket\Valid::inPOST('password'));
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET password=? WHERE id=?", [$password_hash, $customer_id]);
            $_SESSION['message'] = ['success', lang('messages_recovery_password_complete'), 7000, TRUE];
        } else {
            \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            $_SESSION['message'] = ['success', lang('messages_recovery_password_failed'), 7000, TRUE];
        }
    }
}
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>