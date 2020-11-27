<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// Модальное окно
require_once('modal/index.php');
// Модальное окно
require_once('modal/settings.php');

$settings = json_encode(\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . "", [])[0]);

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>