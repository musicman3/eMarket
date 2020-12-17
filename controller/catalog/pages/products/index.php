<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$products = \eMarket\Products::productData(\eMarket\Valid::inGET('id'));

$manufacturer = \eMarket\Products::manufacturer($products['manufacturer'])['name'];

$vendor_code = \eMarket\Products::vendorCode($products['vendor_code'])['name'];

if ($vendor_code != NULL && $vendor_code != FALSE) {
    $vendor_code_value = $products['vendor_code_value'];
}

$weight = \eMarket\Products::weight($products['weight'])['code'];

if ($weight != NULL && $weight != FALSE) {
    $weight_value = $products['weight_value'];
}

$dimension_name = \eMarket\Products::length($products['dimension'])['code'];
$dimensions = '';
$dimension_marker = 0;

if ($products['length'] != NULL && $products['length'] != FALSE) {
    $dimensions .= $products['length'] . ' (' . lang('product_dimension_length') . ')';
    $dimension_marker++;
}

if ($products['width'] != NULL && $products['width'] != FALSE) {
    if ($dimension_marker > 0) {
        $dimensions .= ' x ' . $products['width'] . ' (' . lang('product_dimension_width') . ')';
        $dimension_marker++;
    } else {
        $dimensions .= $products['width'] . ' (' . lang('product_dimension_width') . ')';
        $dimension_marker++;
    }
}

if ($products['height'] != NULL && $products['height'] != FALSE) {
    if ($dimension_marker > 0) {
        $dimensions .= ' x ' . $products['height'] . ' (' . lang('product_dimension_height') . ')';
        $dimension_marker++;
    } else {
        $dimensions .= $products['height'] . ' (' . lang('product_dimension_height') . ')';
        $dimension_marker++;
    }
}

$images = \eMarket\Func::deleteValInArray(json_decode($products['logo'], 1), [$products['logo_general']]);
$categories_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], \eMarket\Valid::inGET('category_id')])[0];
$categories_name = $categories_data['name'];
$category_parent_id = $categories_data['parent_id'];

if (\eMarket\Valid::inGET('category_id') == 0) {
    $attributes_data = json_encode([]);
} else {
    $attributes_data = json_encode($categories_data['attributes']);
}

require_once('modal/cart_message.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
\eMarket\Settings::$JS_END = __DIR__;
?>
