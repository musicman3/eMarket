<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// собираем данные для отображения в Редактировании
$json_data = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $query_lang = \eMarket\Pdo::getRow("SELECT name, code FROM " . TABLE_WEIGHT . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $name[$x][$modal_id] = $query_lang[0];
            $code[$x][$modal_id] = $query_lang[1];
        }

        $query = \eMarket\Pdo::getRow("SELECT value_weight, default_weight FROM " . TABLE_WEIGHT . " WHERE id=?", [$modal_id]);
        $value[$modal_id] = (float) $query[0];
        $status[$modal_id] = (int) $query[1];

        $json_data = json_encode([
            'name' => $name,
            'code' => $code,
            'value' => $value,
            'status' => $status
        ]);
    }
}
?>
