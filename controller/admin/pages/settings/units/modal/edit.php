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

        for ($xl = 0; $xl < $count_lang; $xl++) {
            $name_edit_temp[$xl][$modal_id] = $PDO->selectPrepare("SELECT name FROM " . TABLE_UNITS . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$xl]]);
            $code_edit_temp[$xl][$modal_id] = $PDO->selectPrepare("SELECT unit FROM " . TABLE_UNITS . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$xl]]);
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
