<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Считываем значение
$lines_on_page = $PDO->selectPrepare("SELECT lines_on_page FROM " . TABLE_BASIC_SETTINGS, []);
?>