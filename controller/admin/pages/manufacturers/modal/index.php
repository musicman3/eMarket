<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $name_temp[$x][$modal_id] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_MANUFACTURERS . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }
        
        $query = \eMarket\Pdo::getRow("SELECT site, logo, logo_general FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$modal_id]);
        $site_temp[$modal_id] = $query[0];
        $logo_temp[$modal_id] = explode(',', $query[1], -1);
        $logo_general_temp[$modal_id] = $query[2];
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name = json_encode($name_temp); // Имя
        $site = json_encode($site_temp); // Короткое имя
        $logo = json_encode($logo_temp); // Список изображений
        $logo_general = json_encode($logo_general_temp); // Главное изображение
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name = ''; // Имя
    $site = ''; // Короткое имя
    $logo = ''; // Список изображений
    $logo_general = ''; // Главное изображение
}

?>
