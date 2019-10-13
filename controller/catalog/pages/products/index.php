<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$cart_info = \eMarket\Other\Cart::info();

$products = \eMarket\Other\Products::productData($VALID->inGET('id'))[0];
$product_category = \eMarket\Other\Products::productCategories($products['parent_id']);
$product_price = \eMarket\Other\Products::productPrice($products['price'], $CURRENCIES, 1);
$categories_name = \eMarket\Core\Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $VALID->inGET('category_id')]);
$category_parent_id = \eMarket\Core\Pdo::getCell("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $VALID->inGET('category_id')]);

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>