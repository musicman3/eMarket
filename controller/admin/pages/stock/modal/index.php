<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании категорий
$json_data_category = json_encode(json_encode([]));
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines_cat[$i]['id']) == TRUE) {

        $modal_id = $lines_cat[$i]['id']; // ID

        foreach ($sql_data_cat as $sql_modal_cat) {
            //Языковые
            if ($sql_modal_cat['id'] == $modal_id) {
                $name[array_search($sql_modal_cat['language'], lang('#lang_all'))][$modal_id] = $sql_modal_cat['name'];
            }
            if ($sql_modal_cat['language'] == lang('#lang_all')[0] && $sql_modal_cat['id'] == $modal_id) {
                $logo[$modal_id] = json_decode($sql_modal_cat['logo'], 1);
                $logo_general[$modal_id] = $sql_modal_cat['logo_general'];
                $attributes[$modal_id] = json_decode($sql_modal_cat['attributes']);
            }
        }
        //Сортируем языковые
        ksort($name);

        $json_data_category = json_encode([
            'name' => $name,
            'logo' => $logo,
            'logo_general' => $logo_general,
            'attributes' => $attributes
        ]);
    }
}
?>
