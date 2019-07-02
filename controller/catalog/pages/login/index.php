<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if ($VALID->inGET('activation_code')) {
    $id_actvation = $PDO->selectPrepare("SELECT id FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE activation_code=?", [$VALID->inGET('activation_code')]);
    if ($id_actvation != NULL) {
        $account_date = $PDO->selectPrepare("SELECT UNIX_TIMESTAMP (date_account_created) FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
        // Если дата активации не истекла
        if ($account_date + (3 * 24 * 60 * 60) > time()) {
            $PDO->inPrepare("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
            $PDO->inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [1, $id_actvation]);
            $_SESSION['message'] = ['success', lang('messages_activation_complete'), 7000, TRUE];
        } else {
            $PDO->inPrepare("DELETE FROM " . TABLE_CUSTOMERS_ACTIVATION . " WHERE id=?", [$id_actvation]);
            $PDO->inPrepare("DELETE FROM " . TABLE_CUSTOMERS . " WHERE id=?", [$id_actvation]);
        }
    }
}

if ($VALID->inPOST('email')) {
    $HASH = $PDO->selectPrepare("SELECT password FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$VALID->inPOST('email')]);
    if (!password_verify($VALID->inPOST('password'), $HASH)) {
        $_SESSION['message'] = ['danger', lang('messages_email_or_password_is_not_correct'), 7000, TRUE];
    } else {
        $_SESSION['password_customer'] = $HASH;
        $_SESSION['email_customer'] = $VALID->inPOST('email');
        header('Location: ' . HTTP_SERVER);
    }
}


if ($VALID->inGET('logout')) {
    unset($_SESSION['password_customer']);
    unset($_SESSION['email_customer']);
    header('Location: ?route=' . $VALID->inGET('route'));
}

?>