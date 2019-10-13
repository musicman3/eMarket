<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$products = \eMarket\Core\Pdo::getColAssoc("SELECT id, name, logo_general, price FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=? ORDER BY date_added DESC", [lang('#lang_all')[0], \eMarket\Core\Valid::inGET('category_id')]);
$categories_name = \eMarket\Core\Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], \eMarket\Core\Valid::inGET('category_id')]);
?>