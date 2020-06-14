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
            $query_lang = \eMarket\Pdo::getRow("SELECT name, code FROM " . TABLE_LENGTH . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $name_temp[$x][$modal_id] = $query_lang[0];
            $code_temp[$x][$modal_id] = $query_lang[1];
        }
        $query = \eMarket\Pdo::getRow("SELECT value_length, default_length FROM " . TABLE_LENGTH . " WHERE id=?", [$modal_id]);
        $value_length_temp[$modal_id] = (float) $query[0];
        $status_length_temp[$modal_id] = (int) $query[1];
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name = json_encode($name_temp); // Имя
        $code = json_encode($code_temp); // Короткое имя
        $value_length = json_encode($value_length_temp); // Значение
        $status_length = json_encode($status_length_temp); // Статус
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name = ''; // Имя
    $code = ''; // Короткое имя
    $value_length = ''; // Значение
    $status_length = ''; // Статус
}

?>