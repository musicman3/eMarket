<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$resize_param = [];
array_push($resize_param, ['125', '94']); // width, height
//
$resize_param_product = [];
array_push($resize_param_product, ['125', '94']); // width, height
array_push($resize_param_product, ['200', '150']);
array_push($resize_param_product, ['325', '244']);
array_push($resize_param_product, ['525', '394']);
array_push($resize_param_product, ['850', '638']);

$EAC_ENGINE = \eMarket\Eac::init($resize_param, $resize_param_product);
$idsx_real_parent_id = $EAC_ENGINE[0];
$parent_id = $EAC_ENGINE[1];

$installed_active = \eMarket\Pdo::getCell("SELECT id FROM " . TABLE_MODULES . " WHERE name=? AND type=? AND active=?", ['sale', 'discount', 1]);
$sales = '';
$sale_default = 0;
$sale_default_flag = 0;
$sales_flag = 0;
$select_array = [];

if ($installed_active != '') {
    $sales_all = \eMarket\Pdo::getColAssoc("SELECT id, name, default_set FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=?", [lang('#lang_all')[0]]);
}

if ($installed_active != '' && isset($sales_all) && count($sales_all) > 0) {
    $this_time = time();

    foreach ($sales_all as $val) {
        $date_end = \eMarket\Pdo::getCell("SELECT UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE id=?", [$val['id']]);
        if ($this_time < $date_end) {
            $sales_flag = 1;
            $sales .= $val['id'] . ': ' . "'" . $val['name'] . "', ";
            array_push($select_array, $val['id']);
            if ($val['default_set'] == 1) {
                $sale_default = $val['id'];
                $sale_default_flag = 1;
            } elseif ($sale_default_flag == 0) {
                $sale_default = $val['id'];
                $sale_default_flag = 1;
            }
        }
    }
}

$stikers = '';
$stikers_default = 0;
$stikers_flag = 0;
$stikers_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [lang('#lang_all')[0]]);

foreach ($stikers_data as $val) {
    $stikers_flag = 1;
    $stikers .= $val['id'] . ': ' . "'" . $val['name'] . "', ";
    if ($val['default_stikers'] == 1) {
        $stikers_default = $val['id'];
    }
}

$currencies_all = \eMarket\Pdo::getColAssoc("SELECT name, default_value, id FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);
$taxes_all = \eMarket\Pdo::getColAssoc("SELECT name, id FROM " . TABLE_TAXES . " WHERE language=?", [lang('#lang_all')[0]]);
$units_all = \eMarket\Pdo::getColAssoc("SELECT name, default_unit, id FROM " . TABLE_UNITS . " WHERE language=?", [lang('#lang_all')[0]]);
$length_all = \eMarket\Pdo::getColAssoc("SELECT name, default_length, id FROM " . TABLE_LENGTH . " WHERE language=?", [lang('#lang_all')[0]]);
$weight_all = \eMarket\Pdo::getColAssoc("SELECT name, default_weight, id FROM " . TABLE_WEIGHT . " WHERE language=?", [lang('#lang_all')[0]]);
$vendor_codes_all = \eMarket\Pdo::getColAssoc("SELECT name, default_vendor_code, id FROM " . TABLE_VENDOR_CODES . " WHERE language=?", [lang('#lang_all')[0]]);
$manufacturers_all = \eMarket\Pdo::getColAssoc("SELECT name, id FROM " . TABLE_MANUFACTURERS . " WHERE language=?", [lang('#lang_all')[0]]);

if (\eMarket\Valid::inGET('nav_parent_id')) {
    $parent_id = \eMarket\Valid::inGET('nav_parent_id');
}

if (!isset($idsx_real_parent_id)) {
    $idsx_real_parent_id = '';
}

if (isset($_SESSION['buffer'])) {
    $ses_verify = count($_SESSION['buffer']);
} else {
    $ses_verify = '0';
}

if ($parent_id == 0) {
    $attributes_category = json_encode(json_encode([]));
} else {
    $attributes_category = json_encode(\eMarket\Pdo::getColAssoc("SELECT attributes FROM " . TABLE_CATEGORIES . " WHERE id=? AND language=?", [$parent_id, lang('#lang_all')[0]])[0]['attributes']);
}

$stiker_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [lang('#lang_all')[0]]);
$stiker_name = [];
foreach ($stiker_data as $val) {
    $stiker_name[$val['id']] = $val['name'];
}

$transfer = 0;

$lines_on_page = \eMarket\Settings::linesOnPage();
$search = '%' . \eMarket\Valid::inGET('search') . '%';
if (\eMarket\Valid::inGET('search')) {
    $sql_data_cat_search = \eMarket\Pdo::getColAssoc("SELECT id FROM " . TABLE_CATEGORIES . " WHERE name LIKE? AND language=? ORDER BY sort_category DESC", [$search, lang('#lang_all')[0]]);
    $sql_data_cat = [];
    foreach ($sql_data_cat_search as $sql_data_cat_search_val) {
        foreach (\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CATEGORIES . " WHERE id=? ORDER BY sort_category DESC", [$sql_data_cat_search_val['id']]) as $cat_array) {
            $sql_data_cat[] = $cat_array;
        }
    }
    $lines_cat = \eMarket\Func::filterData($sql_data_cat, 'language', lang('#lang_all')[0]);

    $sql_data_prod_search = \eMarket\Pdo::getColAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE (name LIKE? OR description LIKE?) AND language=? ORDER BY id DESC", [$search, $search, lang('#lang_all')[0]]);
    $sql_data_prod = [];
    foreach ($sql_data_prod_search as $sql_data_prod_search_val) {
        foreach (\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? ORDER BY id DESC", [$sql_data_prod_search_val['id']]) as $prod_array) {
            $sql_data_prod[] = $prod_array;
        }
    }
    $lines_prod = \eMarket\Func::filterData($sql_data_prod, 'language', lang('#lang_all')[0]);
} else {
    $sql_data_cat = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent_id=? ORDER BY sort_category DESC", [$parent_id]);
    $lines_cat = \eMarket\Func::filterData($sql_data_cat, 'language', lang('#lang_all')[0]);
    $sql_data_prod = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE parent_id=? ORDER BY id DESC", [$parent_id]);
    $lines_prod = \eMarket\Func::filterData($sql_data_prod, 'language', lang('#lang_all')[0]);
}
$count_lines_cat = count($lines_cat);
$count_lines_prod = count($lines_prod);

$arr_merge = \eMarket\Func::arrayMergeOriginKey('cat', 'prod', $lines_cat, $lines_prod);

$count_lines_merge = $count_lines_cat + $count_lines_prod;

$navigate = \eMarket\Navigation::getLink($count_lines_merge, $lines_on_page, 1);
$start = $navigate[0];
$finish = $navigate[1];

require_once('modal/index.php');
require_once('modal/index_product.php');

