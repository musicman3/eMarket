<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$resize_param = [];
array_push($resize_param, ['125', '94']); // ширина, высота
//
$resize_param_product = [];
array_push($resize_param_product, ['125', '94']); // ширина, высота
array_push($resize_param_product, ['200', '150']);
array_push($resize_param_product, ['325', '244']);
array_push($resize_param_product, ['525', '394']);
array_push($resize_param_product, ['850', '638']);

// Создаем массив используемых таблиц в EAC
$TABLES = [
    TABLE_CATEGORIES,
    TABLE_PRODUCTS,
    TABLE_TAXES,
    TABLE_UNITS,
    TABLE_MANUFACTURERS,
    TABLE_VENDOR_CODES,
    TABLE_WEIGHT,
    TABLE_LENGTH,
    TABLE_CURRENCIES
];
// Загружаем движок EAC
$EAC_ENGINE = \eMarket\Eac::init($TABLES, $resize_param, $resize_param_product);
$idsx_real_parent_id = $EAC_ENGINE[0];
$parent_id = $EAC_ENGINE[1];

// Формируем распродажу для выпадающего списка
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
// Формируем список стикеров
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
// Формируем массив Валюта для выпадающего списка
$currencies_all = \eMarket\Pdo::getColAssoc("SELECT name, default_value, id FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);

// Формируем массив Налог для выпадающего списка
$taxes_all = \eMarket\Pdo::getColAssoc("SELECT name, id FROM " . TABLE_TAXES . " WHERE language=?", [lang('#lang_all')[0]]);

// Формируем массив Единица измерения для выпадающего списка
$units_all = \eMarket\Pdo::getColAssoc("SELECT name, default_unit, id FROM " . TABLE_UNITS . " WHERE language=?", [lang('#lang_all')[0]]);

// Формируем массив Размер измерения для выпадающего списка
$length_all = \eMarket\Pdo::getColAssoc("SELECT name, default_length, id FROM " . TABLE_LENGTH . " WHERE language=?", [lang('#lang_all')[0]]);

// Формируем массив Вес измерения для выпадающего списка
$weight_all = \eMarket\Pdo::getColAssoc("SELECT name, default_weight, id FROM " . TABLE_WEIGHT . " WHERE language=?", [lang('#lang_all')[0]]);

// Формируем массив Вес измерения для выпадающего списка
$vendor_codes_all = \eMarket\Pdo::getColAssoc("SELECT name, default_vendor_code, id FROM " . TABLE_VENDOR_CODES . " WHERE language=?", [lang('#lang_all')[0]]);

// Формируем массив Производитель измерения для выпадающего списка
$manufacturers_all = \eMarket\Pdo::getColAssoc("SELECT name, id FROM " . TABLE_MANUFACTURERS . " WHERE language=?", [lang('#lang_all')[0]]);

// Устанавливаем родительскую категорию при навигации назад-вперед
if (\eMarket\Valid::inGET('parent_id_temp')) {
    $parent_id = \eMarket\Valid::inGET('parent_id_temp');
}

// Параметры для JS
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
// Счетчик трансфера
$transfer = 0;

// КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines_on_page = \eMarket\Set::linesOnPage();
$search = '%' . \eMarket\Valid::inGET('search') . '%';
if (\eMarket\Valid::inGET('search')) {
    $sql_data_cat_search = \eMarket\Pdo::getColAssoc("SELECT id FROM " . TABLE_CATEGORIES . " WHERE name LIKE? ORDER BY sort_category DESC", [$search]);
    $sql_data_cat = [];
    foreach ($sql_data_cat_search as $sql_data_cat_search_val) {
        foreach (\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CATEGORIES . " WHERE id=? ORDER BY sort_category DESC", [$sql_data_cat_search_val['id']]) as $cat_array) {
            $sql_data_cat[] = $cat_array;
        }
    }
    $lines_cat = \eMarket\Func::filterData($sql_data_cat, 'language', lang('#lang_all')[0]);

    $sql_data_prod_search = \eMarket\Pdo::getColAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE (name LIKE? OR description LIKE?) ORDER BY id DESC", [$search, $search]);
    $sql_data_prod = [];
    foreach ($sql_data_prod_search as $sql_data_prod_search_val) {
        foreach (\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CATEGORIES . " WHERE id=? ORDER BY id DESC", [$sql_data_prod_search_val['id']]) as $prod_array) {
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
$count_lines_cat = count($lines_cat);  //считаем количество строк
$count_lines_prod = count($lines_prod);  //считаем количество строк

$arr_merge = \eMarket\Func::arrayMergeOriginKey('cat', 'prod', $lines_cat, $lines_prod);

//\eMarket\Debug::trace($arr_merge);
$count_lines_merge = $count_lines_cat + $count_lines_prod; // Считаем общее количество строк в категории

$navigate = \eMarket\Navigation::getLink($count_lines_merge, $lines_on_page, 1);
$start = $navigate[0];
$finish = $navigate[1];

// КОНЕЦ-> КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// Модальное окно
require_once('modal/index.php');
require_once('modal/index_product.php');
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>
