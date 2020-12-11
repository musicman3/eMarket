<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании
$json_data = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i]['id']) == TRUE) {

        $modal_id = $lines[$i]['id']; // ID

        foreach ($lines as $sql_modal) {
            if ($sql_modal['id'] == $modal_id) {
                $sql_modal['date_purchased'] = \eMarket\Set::dateLocale($sql_modal['date_purchased'], '%c');
                $orders[$modal_id] = $sql_modal;
            }
        }

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $json_data = json_encode($orders);
    }
}

?>
