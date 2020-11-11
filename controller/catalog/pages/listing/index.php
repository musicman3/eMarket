<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inGET('change') == 'on' OR !\eMarket\Valid::inGET('change')) {
    $checked_stock = ' checked';
    $qnt_flag = '';
} else {
    $checked_stock = '';
    $qnt_flag = 'AND quantity>0 ';
}

if (!\eMarket\Valid::inGET('sort') OR \eMarket\Valid::inGET('sort') == 'default') {
    $sort_parameter = $qnt_flag . 'ORDER BY id DESC';
    $sort_name = 'По умолчанию';
}
if (\eMarket\Valid::inGET('sort') == 'down') {
    $sort_parameter = $qnt_flag . 'ORDER BY price DESC';
    $sort_name = 'По названию';
}
if (\eMarket\Valid::inGET('sort') == 'up') {
    $sort_parameter = $qnt_flag . 'ORDER BY price ASC';
    $sort_name = 'Цена (по убыванию)';
}
if (\eMarket\Valid::inGET('sort') == 'name') {
    $sort_parameter = $qnt_flag . 'ORDER BY name ASC';
    $sort_name = 'Цена (по возрастанию)';
}

if (\eMarket\Valid::inGET('search')) {
    $search = '%' . \eMarket\Valid::inGET('search') . '%';
    $lines = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE (name LIKE? OR description LIKE?) AND language=? AND status=? " . $sort_parameter, [$search, $search, lang('#lang_all')[0], 1]);
} else {
    $lines = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=? AND status=? " . $sort_parameter, [lang('#lang_all')[0], \eMarket\Valid::inGET('category_id'), 1]);
}
$lines_on_page = \eMarket\Set::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

$categories_name = \eMarket\Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], \eMarket\Valid::inGET('category_id')]);

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>