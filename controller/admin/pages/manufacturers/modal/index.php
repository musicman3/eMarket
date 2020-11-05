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
            $name[$x][$modal_id] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_MANUFACTURERS . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }

        $query = \eMarket\Pdo::getRow("SELECT site, logo, logo_general FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$modal_id]);
        $site[$modal_id] = $query[0];
        $logo[$modal_id] = explode(',', $query[1], -1);
        $logo_general[$modal_id] = $query[2];

        $json_data = json_encode([
            'name' => $name,
            'site' => $site,
            'logo' => $logo,
            'logo_general' => $logo_general
        ]);
    }
}
?>
