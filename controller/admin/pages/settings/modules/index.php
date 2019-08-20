<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */


//$MODULES->init();

$payment_installed = $PDO->getColAssoc("SELECT name FROM " . TABLE_MODULES . " WHERE type=?", ['payment']);

//$DEBUG->trace($payment_installed);
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>