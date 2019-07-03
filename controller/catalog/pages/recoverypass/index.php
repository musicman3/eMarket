<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */


if ($VALID->inGET('recovery_code')) {
    $customer_id = $PDO->getCellFalse("SELECT customer_id FROM " . TABLE_PASSWORD_RECOVERY . " WHERE recovery_code=?", [$VALID->inGET('recovery_code')]);
    if ($customer_id != FALSE && $VALID->inPOST('password')) {
        $recovery_code_created = $PDO->selectPrepare("SELECT UNIX_TIMESTAMP (recovery_code_created) FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
        // Если дата активации не истекла
        if ($recovery_code_created + (3 * 24 * 60 * 60) > time()) {
            $PDO->inPrepare("DELETE FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            
            $password_hash = $AUTORIZE->passwordHash($VALID->inPOST('password'));
            $PDO->inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET password=? WHERE id=?", [$password_hash, $customer_id]);
            $_SESSION['message'] = ['success', lang('messages_recovery_password_complete'), 7000, TRUE];
        } else {
            $PDO->inPrepare("DELETE FROM " . TABLE_PASSWORD_RECOVERY . " WHERE customer_id=?", [$customer_id]);
            $_SESSION['message'] = ['success', lang('messages_recovery_password_failed'), 7000, TRUE];
        }
    }
}

?>