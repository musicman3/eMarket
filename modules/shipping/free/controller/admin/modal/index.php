<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
$json_data = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID

        $query = \eMarket\Core\Pdo::getRow("SELECT minimum_price, shipping_zone, currency FROM " . $MODULE_DB . " WHERE id=?", [$modal_id]);
        $minimum_price[$modal_id] = round(\eMarket\Core\Ecb::currencyPrice($query[0], $query[2]), 2);
        $shipping_zone[$modal_id] = $query[1];
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $json_data = json_encode([
            'price' => $minimum_price,
            'zone' => $shipping_zone
        ]);
    }
}
?>
