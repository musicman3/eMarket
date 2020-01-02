<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// собираем данные для отображения в Редактировании
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID
        
        $query = \eMarket\Pdo::getRow("SELECT minimum_price, shipping_zone FROM " . $MODULE_DB . " WHERE id=?", [$modal_id]);
        $minimum_price_edit_temp[$modal_id] = $query[0];
        $shipping_zone_edit_temp[$modal_id] = $query[1];
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $minimum_price_edit = json_encode($minimum_price_edit_temp);
        $shipping_zone_edit = json_encode($shipping_zone_edit_temp);
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $minimum_price_edit = '';
    $shipping_zone_edit = '';
}

?>
