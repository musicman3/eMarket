<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$products_new = \eMarket\Products::viewNew(10);
$category_parent_id = [];
foreach ($products_new as $value) {
    array_push($category_parent_id, \eMarket\Pdo::getCell("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value['parent_id']]));
}
?>