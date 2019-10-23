<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Список зон
$zones = \eMarket\Pdo::getColAssoc("SELECT id, name FROM " . TABLE_ZONES . " WHERE language=? ORDER BY name", [lang('#lang_all')[0]]);

// Загружаем разметку модуля
require_once (\eMarket\View::routingModules('view') . '/index.php');

?>