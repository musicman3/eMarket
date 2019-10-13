<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Список зон
$zones = \eMarket\Core\Pdo::getColAssoc("SELECT id, name FROM " . TABLE_ZONES . " WHERE language=? ORDER BY name", [lang('#lang_all')[0]]);

// Загружаем разметку модуля
require_once (__DIR__ . '../../view/admin.php');

?>