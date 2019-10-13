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
            $query_lang = \eMarket\Pdo::getRow("SELECT name, vendor_code FROM " . TABLE_VENDOR_CODES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $name_edit_temp[$x][$modal_id] = $query_lang[0];
            $code_edit_temp[$x][$modal_id] = $query_lang[1];
        }

        $default_vendor_code_edit_temp[$modal_id] = (int) \eMarket\Pdo::selectPrepare("SELECT default_vendor_code FROM " . TABLE_VENDOR_CODES . " WHERE id=?", [$modal_id]);

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit = json_encode($name_edit_temp); // Имя
        $code_edit = json_encode($code_edit_temp); // Короткое имя
        $default_vendor_code_edit = json_encode($default_vendor_code_edit_temp); // Статус
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name_edit = ''; // Имя
    $code_edit = ''; // Короткое имя
    $default_vendor_code_edit = ''; // Статус
}

?>
