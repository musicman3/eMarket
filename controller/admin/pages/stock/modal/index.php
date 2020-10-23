<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании категорий
$json_data_category = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines_cat[$i][0]) == TRUE) {

        $modal_id = $lines_cat[$i][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $name[$x][$modal_id] = \eMarket\Pdo::selectPrepare("SELECT name FROM " . TABLE_CATEGORIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }
        $query = \eMarket\Pdo::getRow("SELECT logo, logo_general, attributes FROM " . TABLE_CATEGORIES . " WHERE id=?", [$modal_id]);
        $logo[$modal_id] = explode(',', $query[0], -1);
        $logo_general[$modal_id] = $query[1];
        $attributes[$modal_id] = json_decode($query[2]);

        $json_data_category = json_encode([
            'name' => $name,
            'logo' => $logo,
            'logo_general' => $logo_general,
            'attributes' => $attributes
        ]);
    }
}
?>
