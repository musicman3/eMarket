<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$active = \eMarket\Pdo::getCellFalse("SELECT active FROM " . TABLE_MODULES . " WHERE type=? AND name=?", [\eMarket\Valid::inGET('type'), \eMarket\Valid::inGET('name')])[0];

if ($active == 1){
    $switch = 'checked';
}else{
    $switch = '';
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>