<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (!\eMarket\Valid::inGET('sort') OR \eMarket\Valid::inGET('sort') == 'id') {
    $sort_parameter = 'ORDER BY id DESC';
}
if (\eMarket\Valid::inGET('sort') == 'min') {
    $sort_parameter = 'ORDER BY price DESC';
}
if (\eMarket\Valid::inGET('sort') == 'max') {
    $sort_parameter = 'ORDER BY price ASC';
}
if (\eMarket\Valid::inGET('sort') == 'name') {
    $sort_parameter = 'ORDER BY name ASC';
}

if (\eMarket\Valid::inGET('search')) {
    $search = '%' . \eMarket\Valid::inGET('search') . '%';
    $products = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE (name LIKE? OR description LIKE?) AND language=? AND status=? " . $sort_parameter, [$search, $search, lang('#lang_all')[0], 1]);
} else {
    $products = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=? AND status=? " . $sort_parameter, [lang('#lang_all')[0], \eMarket\Valid::inGET('category_id'), 1]);
}

$categories_name = \eMarket\Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], \eMarket\Valid::inGET('category_id')]);

$sort_url = \eMarket\Func::deleteGet('sort');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>