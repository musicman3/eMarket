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
            $name[$x][$modal_id] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_TAXES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }
        $code[$modal_id] = \eMarket\Pdo::selectPrepare("SELECT rate FROM " . TABLE_TAXES . " WHERE id=?", [$modal_id]);

        $json_data = json_encode([
            'name' => $name,
            'code' => $code
        ]);
    }
}
?>
