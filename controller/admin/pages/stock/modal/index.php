<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании категорий
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines_cat[$i][0]) == TRUE) {

        $modal_id = $lines_cat[$i][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $name_temp[$x][$modal_id] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_CATEGORIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }
        $query = \eMarket\Pdo::getRow("SELECT logo, logo_general, attributes FROM " . TABLE_CATEGORIES . " WHERE id=?", [$modal_id]);
        $logo_temp[$modal_id] = explode(',', $query[0], -1);
        $logo_general_temp[$modal_id] = $query[1];
        $attributes_temp[$modal_id] = json_decode($query[2]);

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name = json_encode($name_temp); // Имя
        $logo = json_encode($logo_temp); // Список изображений
        $logo_general = json_encode($logo_general_temp); // Главное изображение
        $attributes = json_encode($attributes_temp); // Атрибуты
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name = ''; // Имя
    $logo = ''; // Список изображений
    $logo_general = ''; // Главное изображение
    $attributes = ''; // Атрибуты
}

?>
