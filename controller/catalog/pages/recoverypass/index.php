<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */


if ($VALID->inGET('recovery_code')) {
    $customer_id = \eMarket\Core\Pdo::getCellFalse("SELECT customer_id FROM " . TABLE_PASSWORD_RECOVERY . " WHERE recovery_code=?", [$VALID->inGET('recovery_code')]);
    if ($customer_id != FALSE && $VALID->inPOST('password')) {
        $recovery_code_created = \eMarket\Core\Pdo::selectPrepare("SELECT UNIX_TIMESTAMP (recovery_code_created) FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
        // Если дата активации не истекла
        if ($recovery_code_created + (3 * 24 * 60 * 60) > time()) {
            \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            
            $password_hash = $AUTORIZE->passwordHash($VALID->inPOST('password'));
            \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET password=? WHERE id=?", [$password_hash, $customer_id]);
            $_SESSION['message'] = ['success', lang('messages_recovery_password_complete'), 7000, TRUE];
        } else {
            \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            $_SESSION['message'] = ['success', lang('messages_recovery_password_failed'), 7000, TRUE];
        }
    }
}
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>