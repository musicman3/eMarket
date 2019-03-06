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
            $name_edit_temp[$x][$modal_id] = $PDO->selectPrepare("SELECT name FROM " . TABLE_CATEGORIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }
        $query = $PDO->getRow("SELECT logo, logo_general FROM " . TABLE_CATEGORIES . " WHERE id=?", [$modal_id]);
        $logo_edit_temp[$modal_id] = explode(',', $query[0], -1);
        $logo_general_edit_temp[$modal_id] = $query[1];

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit = json_encode($name_edit_temp); // Имя
        $logo_edit = json_encode($logo_edit_temp); // Список изображений
        $logo_general = json_encode($logo_general_edit_temp); // Главное изображение
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name_edit = ''; // Имя
    $logo_edit = ''; // Список изображений
    $logo_general = ''; // Главное изображение
}

?>
