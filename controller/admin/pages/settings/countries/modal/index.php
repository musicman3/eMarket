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
            $name[$x][$modal_id] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_COUNTRIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }

        $query = \eMarket\Pdo::getRow("SELECT alpha_2, alpha_3, address_format FROM " . TABLE_COUNTRIES . " WHERE id=?", [$modal_id]);
        $alpha_2[$modal_id] = $query[0];
        $alpha_3[$modal_id] = $query[1];
        $address_format[$modal_id] = $query[2];

        $json_data = json_encode([
            'name' => $name,
            'alpha_2' => $alpha_2,
            'alpha_3' => $alpha_3,
            'address_format' => $address_format
        ]);
    }
}
?>
