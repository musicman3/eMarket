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
            $name_edit_temp[$x][$modal_id] = $PDO->selectPrepare("SELECT name FROM " . TABLE_COUNTRIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }
        
        $query = $PDO->getColRow("SELECT alpha_2, alpha_3, address_format FROM " . TABLE_COUNTRIES . " WHERE id=?", [$modal_id])[0];
        $alpha_2_temp[$modal_id] = $query[0];
        $alpha_3_temp[$modal_id] = $query[1];
        $address_format_temp[$modal_id] = $query[2];

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit = json_encode($name_edit_temp); // Имя
        $alpha_2 = json_encode($alpha_2_temp); // Alpha 2
        $alpha_3 = json_encode($alpha_3_temp); // Alpha 3
        $address_format = json_encode($address_format_temp); // Формат адреса
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name_edit = ''; // Имя
    $alpha_2 = ''; // Alpha 2
    $alpha_3 = ''; // Alpha 3
    $address_format = ''; // Формат адреса
}

?>
