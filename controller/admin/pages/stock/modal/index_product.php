<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании товаров
$json_data_product = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($arr_merge['prod'][$i . 'a']['id']) == TRUE) {

        $modal_id_prod = $arr_merge['prod'][$i . 'a']['id']; // ID

        foreach ($sql_data_prod as $sql_modal_prod) {
            //Языковые
            if ($sql_modal_prod['id'] == $modal_id_prod) {
                $name_product[array_search($sql_modal_prod['language'], lang('#lang_all'))][$modal_id_prod] = $sql_modal_prod['name'];
                $description_product[array_search($sql_modal_prod['language'], lang('#lang_all'))][$modal_id_prod] = $sql_modal_prod['description'];
                $keyword_product[array_search($sql_modal_prod['language'], lang('#lang_all'))][$modal_id_prod] = $sql_modal_prod['keyword'];
                $tags_product[array_search($sql_modal_prod['language'], lang('#lang_all'))][$modal_id_prod] = $sql_modal_prod['tags'];
            }
            if ($sql_modal_prod['language'] == lang('#lang_all')[0] && $sql_modal_prod['id'] == $modal_id_prod) {
                // Цена
                $price_product[$modal_id_prod] = round(\eMarket\Ecb::currencyPrice($sql_modal_prod['price'], $sql_modal_prod['currency']), 2);
                // Валюта
                $currency_product[$modal_id_prod] = \eMarket\Settings::currencyDefault()[0];
                // Количество
                $quantity_product[$modal_id_prod] = $sql_modal_prod['quantity'];
                // Единицы измерения
                $units_product[$modal_id_prod] = $sql_modal_prod['unit'];
                // Модель
                $model_product[$modal_id_prod] = $sql_modal_prod['model'];
                // Производитель
                $manufacturers_product[$modal_id_prod] = $sql_modal_prod['manufacturer'];
                // Дата поступления
                $date_available_product[$modal_id_prod] = $sql_modal_prod['date_available'];
                // Налог
                $tax_product[$modal_id_prod] = $sql_modal_prod['tax'];
                // Значение идентификатора
                $vendor_code_value_product[$modal_id_prod] = $sql_modal_prod['vendor_code_value'];
                // Идентификатор
                $vendor_code_product[$modal_id_prod] = $sql_modal_prod['vendor_code'];
                // Значение Веса
                $weight_value_product[$modal_id_prod] = $sql_modal_prod['weight_value'];
                // Вес
                $weight_product[$modal_id_prod] = $sql_modal_prod['weight'];
                // Минимальное количество
                $min_quantity_product[$modal_id_prod] = $sql_modal_prod['min_quantity'];
                // Ед. изм. длины
                $dimension_product[$modal_id_prod] = $sql_modal_prod['dimension'];
                // Длина
                $length_product[$modal_id_prod] = $sql_modal_prod['length'];
                // Ширина
                $width_product[$modal_id_prod] = $sql_modal_prod['width'];
                // Высота
                $height_product[$modal_id_prod] = $sql_modal_prod['height'];
                // Изображения
                $logo_product[$modal_id_prod] = json_decode($sql_modal_prod['logo'], 1);
                // Главное изображение
                $logo_general_product[$modal_id_prod] = $sql_modal_prod['logo_general'];
                // Атрибуты
                $attributes_product[$modal_id_prod] = json_decode($sql_modal_prod['attributes'], 1);

                if ($parent_id == 0) {
                    $attributes_data[$modal_id_prod] = json_encode(json_encode([]));
                } else {
                    $attributes_data[$modal_id_prod] = json_encode(\eMarket\Pdo::getColAssoc("SELECT attributes FROM " . TABLE_CATEGORIES . " WHERE id=? AND language=?", [$parent_id, lang('#lang_all')[0]])[0]['attributes']);
                }
            }
        }

        //Сортируем языковые
        ksort($name_product);
        ksort($description_product);
        ksort($keyword_product);
        ksort($tags_product);

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
