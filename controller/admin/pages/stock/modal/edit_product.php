<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании категорий
for ($i = $start; $i < $finish; $i++) {
    if (isset($arr_merge['prod'][$i . 'a'][0]) == TRUE) {

        $modal_id_product = $arr_merge['prod'][$i . 'a'][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $name_edit_temp_product[$x][$modal_id_product] = $PDO->selectPrepare("SELECT name FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
            $description_edit_temp_product[$x][$modal_id_product] = $PDO->selectPrepare("SELECT description FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
            $keyword_edit_temp_product[$x][$modal_id_product] = $PDO->selectPrepare("SELECT keyword FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
            $tags_edit_temp_product[$x][$modal_id_product] = $PDO->selectPrepare("SELECT tags FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
        }
        
        // Цена
        $price_edit_temp_product[$modal_id_product] = $PDO->selectPrepare("SELECT price FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product]);

        // Валюта
        $currency[$modal_id_product] = $PDO->selectPrepare("SELECT currency FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product]);
        foreach ($currency as $val) {
            $currency_edit_temp_product[$modal_id_product] = $PDO->selectPrepare("SELECT name FROM " . TABLE_CURRENCIES . " WHERE id=? and language=?", [$val, lang('#lang_all')[0]]);
        }
        
        // Количество
        $quantity_edit_temp_product[$modal_id_product] = $PDO->selectPrepare("SELECT quantity FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product]);

        // Единицы измерения
        $units[$modal_id_product] = $PDO->selectPrepare("SELECT unit FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product]);
        foreach ($units as $val) {
            $units_edit_temp_product[$modal_id_product] = $PDO->selectPrepare("SELECT name FROM " . TABLE_UNITS . " WHERE id=? and language=?", [$val, lang('#lang_all')[0]]);
        }
        
        // Модель
        $model_edit_temp_product[$modal_id_product] = $PDO->selectPrepare("SELECT model FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product]);
        
        // Производитель
        $manufacturer[$modal_id_product] = $PDO->selectPrepare("SELECT manufacturer FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product]);
        foreach ($manufacturer as $val) {
            $manufacturers_edit_temp_product[$modal_id_product] = $PDO->selectPrepare("SELECT name FROM " . TABLE_MANUFACTURERS . " WHERE id=? and language=?", [$val, lang('#lang_all')[0]]);
        }
        
        // Дата поступления
        $date_available_edit_temp_product[$modal_id_product] = $PDO->selectPrepare("SELECT date_available FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product]);
        
        // Налог
        $tax[$modal_id_product] = $PDO->selectPrepare("SELECT tax FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product]);
        foreach ($tax as $val) {
            $tax_edit_temp_product[$modal_id_product] = $PDO->selectPrepare("SELECT name FROM " . TABLE_TAXES . " WHERE id=? and language=?", [$val, lang('#lang_all')[0]]);
        }
        
        //$logo_edit_temp[$modal_id] = explode(',', $PDO->selectPrepare("SELECT logo FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id]), -1);
        //$logo_general_edit_temp[$modal_id] = $PDO->selectPrepare("SELECT logo_general FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id]);
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit_product = json_encode($name_edit_temp_product); // Имя
        $description_edit_product = json_encode($description_edit_temp_product); // Описание
        $keyword_edit_product = json_encode($keyword_edit_temp_product); // Keywords
        $tags_edit_product = json_encode($tags_edit_temp_product); // Tags
        $price_edit_product = json_encode($price_edit_temp_product); // Цена
        $currency_edit_product = json_encode($currency_edit_temp_product); // Валюта
        $quantity_edit_product = json_encode($quantity_edit_temp_product); // Количество
        $units_edit_product = json_encode($units_edit_temp_product); // Единицы измерения
        $model_edit_product = json_encode($model_edit_temp_product); // Модель
        $manufacturers_edit_product = json_encode($manufacturers_edit_temp_product); // Производитель
        $date_available_edit_product = json_encode($date_available_edit_temp_product); // Дата поступления
        $tax_edit_product = json_encode($tax_edit_temp_product); // Налог
        //
        //
        //$logo_edit = json_encode($logo_edit_temp); // Список изображений
        //$logo_general = json_encode($logo_general_edit_temp); // Главное изображение
    }
}

//$DEBUG->trace($units_edit_temp_product);

if (!isset($modal_id_product)) {
    $modal_id_product = 'false';
    $name_edit_product = ''; // Имя
    $description_edit_product = ''; // Описание
    $keyword_edit_product = ''; // Keywords
    $tags_edit_product = ''; // Tags
    $price_edit_product = ''; // Цена
    $currency_edit_product = ''; // Валюта
    $quantity_edit_product = ''; // Количество
    $units_edit_product = ''; // Единицы измерения
    $model_edit_product = ''; // Модель
    $manufacturers_edit_product = ''; // Производитель
    $date_available_edit_product = ''; // Дата поступления
    $tax_edit_product = ''; // Налог
}

?>
