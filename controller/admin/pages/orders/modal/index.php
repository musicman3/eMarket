<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID
        
        $query = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE id=?", [$modal_id])[0];
        $query['date_purchased'] = \eMarket\Set::dateLocale($query['date_purchased'], '%c');
        $orders_temp[$modal_id] = $query;

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $orders = json_encode($orders_temp);
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $orders = '';
}

?>
