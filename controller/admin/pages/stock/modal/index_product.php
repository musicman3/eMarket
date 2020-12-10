<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании товаров
$json_data_product = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($arr_merge['prod'][$i . 'a'][0]) == TRUE) {

        $modal_id_product = $arr_merge['prod'][$i . 'a'][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $query_lang = \eMarket\Pdo::getRow("SELECT name, description, keyword, tags FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
            $name_product[$x][$modal_id_product] = $query_lang[0];
            $description_product[$x][$modal_id_product] = $query_lang[1];
            $keyword_product[$x][$modal_id_product] = $query_lang[2];
            $tags_product[$x][$modal_id_product] = $query_lang[3];
        }

        // Общий запрос
        $query = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product])[0];

        // Цена
        $price_product[$modal_id_product] = round(\eMarket\Ecb::currencyPrice($query['price'], $query['currency']), 2);

        // Валюта
        $currency_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_CURRENCIES . " WHERE id=? and language=?", [\eMarket\Set::currencyDefault()[0], lang('#lang_all')[0]]);

        // Количество
        $quantity_product[$modal_id_product] = $query['quantity'];

        // Единицы измерения
        $units_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_UNITS . " WHERE id=? and language=?", [$query['unit'], lang('#lang_all')[0]]);

        // Модель
        $model_product[$modal_id_product] = $query['model'];

        // Производитель
        $manufacturers_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_MANUFACTURERS . " WHERE id=? and language=?", [$query['manufacturer'], lang('#lang_all')[0]]);

        // Дата поступления
        $date_available_product[$modal_id_product] = $query['date_available'];

        // Налог
        $tax_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_TAXES . " WHERE id=? and language=?", [$query['tax'], lang('#lang_all')[0]]);

        // Значение идентификатора
        $vendor_code_value_product[$modal_id_product] = $query['vendor_code_value'];

        // Идентификатор
        $vendor_code_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_VENDOR_CODES . " WHERE id=? and language=?", [$query['vendor_code'], lang('#lang_all')[0]]);

        // Значение Веса
        $weight_value_product[$modal_id_product] = $query['weight_value'];

        // Вес
        $weight_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_WEIGHT . " WHERE id=? and language=?", [$query['weight'], lang('#lang_all')[0]]);

        // Минимальное количество
        $min_quantity_product[$modal_id_product] = $query['min_quantity'];

        // Ед. изм. длины
        $dimension_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_LENGTH . " WHERE id=? and language=?", [$query['dimension'], lang('#lang_all')[0]]);

        // Длина
        $length_product[$modal_id_product] = $query['length'];

        // Ширина
        $width_product[$modal_id_product] = $query['width'];

        // Высота
        $height_product[$modal_id_product] = $query['height'];

        $logo_product[$modal_id_product] = json_decode($query['logo'], 1);
        $logo_general_product[$modal_id_product] = $query['logo_general'];

        // Атрибуты
        $attributes_product[$modal_id_product] = json_decode($query['attributes'], 1);

        $parent_id = $query['parent_id'];

        if ($parent_id == 0) {
            $attributes_data[$modal_id_product] = json_encode(json_encode([]));
        } else {
            $attributes_data[$modal_id_product] = json_encode(\eMarket\Pdo::getColAssoc("SELECT attributes FROM " . TABLE_CATEGORIES . " WHERE id=? AND language=?", [$parent_id, lang('#lang_all')[0]])[0]['attributes']);
        }

        $json_data_product = json_encode([
            'name' => $name_product,
            'description' => $description_product,
            'keyword' => $keyword_product,
            'tags' => $tags_product,
            'price' => $price_product,
            'currency' => $currency_product,
            'quantity' => $quantity_product,
            'units' => $units_product,
            'model' => $model_product,
            'manufacturers' => $manufacturers_product,
            'date_available' => $date_available_product,
            'tax' => $tax_product,
            'vendor_code_value' => $vendor_code_value_product,
            'vendor_code' => $vendor_code_product,
            'weight_value' => $weight_value_product,
            'weight' => $weight_product,
            'min_quantity' => $min_quantity_product,
            'dimension' => $dimension_product,
            'length' => $length_product,
            'width' => $width_product,
            'height' => $height_product,
            'logo' => $logo_product,
            'logo_general' => $logo_general_product,
            'attributes' => $attributes_product,
            'attributes_data' => $attributes_data
        ]);
    }
}
?>
