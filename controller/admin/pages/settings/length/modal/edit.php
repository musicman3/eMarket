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
            $query_lang = \eMarket\Core\Pdo::getRow("SELECT name, code FROM " . TABLE_LENGTH . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $name_edit_temp[$x][$modal_id] = $query_lang[0];
            $code_edit_temp[$x][$modal_id] = $query_lang[1];
        }
        $query = \eMarket\Core\Pdo::getRow("SELECT value_length, default_length FROM " . TABLE_LENGTH . " WHERE id=?", [$modal_id]);
        $value_length_edit_temp[$modal_id] = (float) $query[0];
        $status_length_edit_temp[$modal_id] = (int) $query[1];
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit = json_encode($name_edit_temp); // Имя
        $code_edit = json_encode($code_edit_temp); // Короткое имя
        $value_length_edit = json_encode($value_length_edit_temp); // Значение
        $status_length_edit = json_encode($status_length_edit_temp); // Статус
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name_edit = ''; // Имя
    $code_edit = ''; // Короткое имя
    $value_length_edit = ''; // Значение
    $status_length_edit = ''; // Статус
}

?>
