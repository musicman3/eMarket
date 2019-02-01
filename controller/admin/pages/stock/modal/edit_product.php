<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании категорий
for ($i = $start; $i < $finish; $i++) {
    if (isset($arr_merge['prod'][$i.'a'][0]) == TRUE) {
        
        $modal_id_product = $arr_merge['prod'][$i.'a'][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $name_edit_temp_product[$x][$modal_id_product] = $PDO->selectPrepare("SELECT name FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
            $description_edit_temp_product[$x][$modal_id_product] = $PDO->selectPrepare("SELECT description FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id_product, lang('#lang_all')[$x]]);
        }
        //$logo_edit_temp[$modal_id] = explode(',', $PDO->selectPrepare("SELECT logo FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id]), -1);
        //$logo_general_edit_temp[$modal_id] = $PDO->selectPrepare("SELECT logo_general FROM " . TABLE_PRODUCTS . " WHERE id=?", [$modal_id]);

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit_product = json_encode($name_edit_temp_product); // Имя
        $description_edit_product = json_encode($description_edit_temp_product); // Описание
        //$logo_edit = json_encode($logo_edit_temp); // Список изображений
        //$logo_general = json_encode($logo_general_edit_temp); // Главное изображение
    }
}
if (!isset($modal_id_product)) {
    $modal_id_product = 'false';
    $name_edit_product = ''; // Имя
    $description_edit_product = ''; // Описание
}
?>
