<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$json_data = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $query_lang = \eMarket\Pdo::getRow("SELECT name FROM " . $MODULE_DB . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $name[$x][$modal_id] = $query_lang[0];
        }
        
        $query = \eMarket\Pdo::getRow("SELECT sale_value, date_start, date_end, default_set FROM " . $MODULE_DB . " WHERE id=?", [$modal_id]);
        $sale_value[$modal_id] = (float) $query[0];
        $date_start[$modal_id] = $query[1];
        $date_end[$modal_id] = $query[2];
        $default_set[$modal_id] = (int) $query[3];
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $json_data = json_encode([
            'name' => $name,
            'value' => $sale_value,
            'start' => $date_start,
            'end' => $date_end,
            'default' => $default_set
        ]);
    }
}

?>
