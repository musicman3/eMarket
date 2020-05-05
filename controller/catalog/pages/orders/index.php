<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if ($CUSTOMER == FALSE) {
    header('Location: ?route=login'); // переадресация на LOGIN
    exit;
}

$lines = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE email=? ORDER BY id DESC", [$_SESSION['email_customer']]);

$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>