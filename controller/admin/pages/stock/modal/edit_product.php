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
            $query_lang = \eMarket\Pdo::getRow("SELECT name, description, keyword, tags FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
            $name_edit_temp_product[$x][$modal_id_product] = $query_lang[0];
            $description_edit_temp_product[$x][$modal_id_product] = $query_lang[1];
            $keyword_edit_temp_product[$x][$modal_id_product] = $query_lang[2];
            $tags_edit_temp_product[$x][$modal_id_product] = $query_lang[3];
        }

        // Цена
        $query = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id_product])[0];

        $price_edit_temp_product[$modal_id_product] = $query['price'];

        // Валюта
        $currency_edit_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_CURRENCIES . " WHERE id=? and language=?", [$query['currency'], lang('#lang_all')[0]]);
        
        // Количество
        $quantity_edit_temp_product[$modal_id_product] = $query['quantity'];

        // Единицы измерения
        $units_edit_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_UNITS . " WHERE id=? and language=?", [$query['unit'], lang('#lang_all')[0]]);

        // Модель
        $model_edit_temp_product[$modal_id_product] = $query['model'];

        // Производитель
        $manufacturers_edit_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_MANUFACTURERS . " WHERE id=? and language=?", [$query['manufacturer'], lang('#lang_all')[0]]);

        // Дата поступления
        $date_available_edit_temp_product[$modal_id_product] = $query['date_available'];

        // Налог
        $tax_edit_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_TAXES . " WHERE id=? and language=?", [$query['tax'], lang('#lang_all')[0]]);

        // Значение идентификатора
        $vendor_code_value_edit_temp_product[$modal_id_product] = $query['vendor_code_value'];

        // Идентификатор
        $vendor_code_edit_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_VENDOR_CODES . " WHERE id=? and language=?", [$query['vendor_code'], lang('#lang_all')[0]]);
        
        // Значение Веса
        $weight_value_edit_temp_product[$modal_id_product] = $query['weight_value'];

        // Вес
        $weight_edit_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_WEIGHT . " WHERE id=? and language=?", [$query['weight'], lang('#lang_all')[0]]);
        
        // Минимальное количество
        $min_quantity_edit_temp_product[$modal_id_product] = $query['min_quantity'];

        // Ед. изм. длины
        $dimension_edit_temp_product[$modal_id_product] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_LENGTH . " WHERE id=? and language=?", [$query['dimension'], lang('#lang_all')[0]]);
        
        // Длина
        $lenght_edit_temp_product[$modal_id_product] = $query['lenght'];
        
        // Ширина
        $width_edit_temp_product[$modal_id_product] = $query['width'];
        
        // Высота
        $height_edit_temp_product[$modal_id_product] = $query['height'];

        $logo_edit_temp_product[$modal_id_product] = explode(',', $query['logo'], -1);
        $logo_general_edit_temp_product[$modal_id_product] = $query['logo_general'];
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
        $vendor_code_value_edit_product = json_encode($vendor_code_value_edit_temp_product); // Значение идентификатора
        $vendor_code_edit_product = json_encode($vendor_code_edit_temp_product); // Идентификатор
        $weight_value_edit_product = json_encode($weight_value_edit_temp_product); // Значение веса
        $weight_edit_product = json_encode($weight_edit_temp_product); // Вес
        $min_quantity_edit_product = json_encode($min_quantity_edit_temp_product); // Минимальное количество
        $dimension_edit_product = json_encode($dimension_edit_temp_product); // Ед. изм. длины
        $lenght_edit_product = json_encode($lenght_edit_temp_product); // Длина
        $width_edit_product = json_encode($width_edit_temp_product); // Ширина
        $height_edit_product = json_encode($height_edit_temp_product); // Высота
        //
        $logo_edit_product = json_encode($logo_edit_temp_product); // Список изображений
        $logo_general_product = json_encode($logo_general_edit_temp_product); // Главное изображение
    }
}

//\eMarket\Debug::trace($units_edit_temp_product);

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
    $vendor_code_value_edit_product = ''; // Значение идентификатора
    $vendor_code_edit_product = ''; // Идентификатор
    $weight_value_edit_product = ''; // Значение веса
    $weight_edit_product = ''; // Вес
    $min_quantity_edit_product = ''; // Минимальное количество
    $dimension_edit_product = ''; // Ед. изм. длины
    $lenght_edit_product = ''; // Длина
    $width_edit_product = ''; // Ширина
    $height_edit_product = ''; // Высота
    $logo_edit_product = ''; // Список изображений
    $logo_general_product = ''; // Главное изображение
}

?>
