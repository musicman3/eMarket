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
            $name_temp[$x][$modal_id] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_ZONES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }
        $code_temp[$modal_id] = \eMarket\Pdo::selectPrepare("SELECT note FROM " . TABLE_ZONES . " WHERE id=?", [$modal_id]);
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name = json_encode($name_temp); // Имя
        $code = json_encode($code_temp); // Короткое имя
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name = ''; // Имя
    $code = ''; // Короткое имя
}

?>
