<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID
        $count_lang = $_SESSION['lang_count'];

        for ($x = 0; $x < $count_lang; $x++) {
            $name_edit_temp[$x][$modal_id] = $PDO->selectPrepare("SELECT name FROM " . TABLE_VENDOR_CODES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $code_edit_temp[$x][$modal_id] = $PDO->selectPrepare("SELECT vendor_code FROM " . TABLE_VENDOR_CODES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit = json_encode($name_edit_temp); // Имя
        $code_edit = json_encode($code_edit_temp); // Короткое имя
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
}
?>
