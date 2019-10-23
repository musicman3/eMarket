<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$DATABASE = \eMarket\Set::moduleDatabase();


//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
//$JS_MOD_END = __DIR__;
// Загружаем разметку модуля
require_once (\eMarket\View::routingModules('view') . '/index.php');
?>