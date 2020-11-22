<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if ($CUSTOMER == FALSE) {
    header('Location: ?route=login'); // переадресация на LOGIN
    exit;
}

$customer = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
?>