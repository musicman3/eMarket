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
            $query_lang = \eMarket\Pdo::getRow("SELECT name FROM " . $MODULE_DB . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $name_edit_temp[$x][$modal_id] = $query_lang[0];
        }
        
        $query = \eMarket\Pdo::getRow("SELECT sale_value, date_start, date_end, default_set FROM " . $MODULE_DB . " WHERE id=?", [$modal_id]);
        $sale_value_edit_temp[$modal_id] = (float) $query[0];
        $date_start_edit_temp[$modal_id] = $query[1];
        $date_end_edit_temp[$modal_id] = $query[2];
        $default_set_edit_temp[$modal_id] = (int) $query[3];
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit = json_encode($name_edit_temp);
        $sale_value_edit = json_encode($sale_value_edit_temp);
        $date_start_edit = json_encode($date_start_edit_temp);
        $date_end_edit = json_encode($date_end_edit_temp);
        $default_set_edit = json_encode($default_set_edit_temp);
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name_edit = '';
    $sale_value_edit = '';
    $date_start_edit = '';
    $date_end_edit = '';
    $default_set_edit = '';
}

?>
