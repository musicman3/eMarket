<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании товаров
for ($i = $start; $i < $finish; $i++) {
    if (isset($arr_merge['prod'][$i . 'a'][0]) == TRUE) {

        $modal_id_product = $arr_merge['prod'][$i . 'a'][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $query_lang = \eMarket\Pdo::getRow("SELECT name, description, keyword, tags FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
            $name_temp_product[$x][$modal_id_product] = $query_lang[0];
            $description_temp_product[$x][$modal_id_product] = $query_lang[1];
            $keyword_temp_product[$x][$modal_id_product] = $query_lang[2];
            $tags_temp_product[$x][$modal_id_product] = $query_lang[3];
        }

        // Общий запрос
        $query = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product])[0];
        
        // Цена
        $price_temp_product[$modal_id_product] = $query['price'];

        // Валюта
        $currency_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_CURRENCIES . " WHERE id=? and language=?", [$query['currency'], lang('#lang_all')[0]]);
        
        // Количество
        $quantity_temp_product[$modal_id_product] = $query['quantity'];

        // Единицы измерения
        $units_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_UNITS . " WHERE id=? and language=?", [$query['unit'], lang('#lang_all')[0]]);

        // Модель
        $model_temp_product[$modal_id_product] = $query['model'];

        // Производитель
        $manufacturers_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_MANUFACTURERS . " WHERE id=? and language=?", [$query['manufacturer'], lang('#lang_all')[0]]);

        // Дата поступления
        $date_available_temp_product[$modal_id_product] = $query['date_available'];

        // Налог
        $tax_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_TAXES . " WHERE id=? and language=?", [$query['tax'], lang('#lang_all')[0]]);

        // Значение идентификатора
        $vendor_code_value_temp_product[$modal_id_product] = $query['vendor_code_value'];

        // Идентификатор
        $vendor_code_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_VENDOR_CODES . " WHERE id=? and language=?", [$query['vendor_code'], lang('#lang_all')[0]]);
        
        // Значение Веса
        $weight_value_temp_product[$modal_id_product] = $query['weight_value'];

        // Вес
        $weight_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_WEIGHT . " WHERE id=? and language=?", [$query['weight'], lang('#lang_all')[0]]);
        
        // Минимальное количество
        $min_quantity_temp_product[$modal_id_product] = $query['min_quantity'];

        // Ед. изм. длины
        $dimension_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_LENGTH . " WHERE id=? and language=?", [$query['dimension'], lang('#lang_all')[0]]);
        
        // Длина
        $length_temp_product[$modal_id_product] = $query['length'];
        
        // Ширина
        $width_temp_product[$modal_id_product] = $query['width'];
        
        // Высота
        $height_temp_product[$modal_id_product] = $query['height'];

        $logo_temp_product[$modal_id_product] = explode(',', $query['logo'], -1);
        $logo_general_temp_product[$modal_id_product] = $query['logo_general'];
        
        // Атрибуты
        $attributes_temp_product[$modal_id_product] = json_decode($query['attributes'], 1);
        
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_product = json_encode($name_temp_product); // Имя
        $description_product = json_encode($description_temp_product); // Описание
        $keyword_product = json_encode($keyword_temp_product); // Keywords
        $tags_product = json_encode($tags_temp_product); // Tags
        $price_product = json_encode($price_temp_product); // Цена
        $currency_product = json_encode($currency_temp_product); // Валюта
        $quantity_product = json_encode($quantity_temp_product); // Количество
        $units_product = json_encode($units_temp_product); // Единицы измерения
        $model_product = json_encode($model_temp_product); // Модель
        $manufacturers_product = json_encode($manufacturers_temp_product); // Производитель
        $date_available_product = json_encode($date_available_temp_product); // Дата поступления
        $tax_product = json_encode($tax_temp_product); // Налог
        $vendor_code_value_product = json_encode($vendor_code_value_temp_product); // Значение идентификатора
        $vendor_code_product = json_encode($vendor_code_temp_product); // Идентификатор
        $weight_value_product = json_encode($weight_value_temp_product); // Значение веса
        $weight_product = json_encode($weight_temp_product); // Вес
        $min_quantity_product = json_encode($min_quantity_temp_product); // Минимальное количество
        $dimension_product = json_encode($dimension_temp_product); // Ед. изм. длины
        $length_product = json_encode($length_temp_product); // Длина
        $width_product = json_encode($width_temp_product); // Ширина
        $height_product = json_encode($height_temp_product); // Высота
        //
        $logo_product = json_encode($logo_temp_product); // Список изображений
        $logo_general_product = json_encode($logo_general_temp_product); // Главное изображение
        $attributes_product = json_encode($attributes_temp_product); // Атрибуты
    }
}

//\eMarket\Debug::trace($units_temp_product);

if (!isset($modal_id_product)) {
    $modal_id_product = 'false';
    $name_product = ''; // Имя
    $description_product = ''; // Описание
    $keyword_product = ''; // Keywords
    $tags_product = ''; // Tags
    $price_product = ''; // Цена
    $currency_product = ''; // Валюта
    $quantity_product = ''; // Количество
    $units_product = ''; // Единицы измерения
    $model_product = ''; // Модель
    $manufacturers_product = ''; // Производитель
    $date_available_product = ''; // Дата поступления
    $tax_product = ''; // Налог
    $vendor_code_value_product = ''; // Значение идентификатора
    $vendor_code_product = ''; // Идентификатор
    $weight_value_product = ''; // Значение веса
    $weight_product = ''; // Вес
    $min_quantity_product = ''; // Минимальное количество
    $dimension_product = ''; // Ед. изм. длины
    $length_product = ''; // Длина
    $width_product = ''; // Ширина
    $height_product = ''; // Высота
    $logo_product = ''; // Список изображений
    $logo_general_product = ''; // Главное изображение
    $attributes_product = ''; // Атрибуты
}

?>
