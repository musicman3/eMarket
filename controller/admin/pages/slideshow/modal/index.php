<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$json_data = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID

        $query = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW . " WHERE id=?", [$modal_id])[0];
        
        $name[$modal_id] = $query['name'];
        $url[$modal_id] = $query['url'];
        $heading[$modal_id] = $query['heading'];
        $logo[$modal_id] = json_decode($query['logo'], 1);
        $logo_general[$modal_id] = $query['logo_general'];
        $heading[$modal_id] = $query['heading'];
        $date_start[$modal_id] = $query['date_start'];
        $date_finish[$modal_id] = $query['date_finish'];
        $status[$modal_id] = (int) $query['status'];

        $json_data = json_encode([
            'name' => $name,
            'url' => $url,
            'heading' => $heading,
            'logo' => $logo,
            'logo_general' => $logo_general,
            'date_start' => $date_start,
            'date_finish' => $date_finish,
            'status' => $status
        ]);
    }
}
?>
