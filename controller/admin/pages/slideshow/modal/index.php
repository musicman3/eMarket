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


            $name[$modal_id] = \eMarket\Pdo::getRow("SELECT name FROM " . TABLE_SLIDESHOW . " WHERE id=?", [$modal_id]);

        $status[$modal_id] = (int) \eMarket\Pdo::selectPrepare("SELECT status FROM " . TABLE_SLIDESHOW . " WHERE id=?", [$modal_id]);

        $json_data = json_encode([
            'name' => $name,
            'status' => $status
        ]);
    }
}
?>
