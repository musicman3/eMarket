<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (isset($_SESSION['email_customer'])) {
    $name = $PDO->selectPrepare("SELECT lastname FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);
}

?>