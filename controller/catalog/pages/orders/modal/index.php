<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$orders_edit = json_encode([]);
for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
    if (isset($lines[$i]['id']) == TRUE) {

        $modal_id = $lines[$i]['id'];

        foreach ($lines as $sql_modal) {
            if ($sql_modal['id'] == $modal_id) {
                $orders[$modal_id] = $sql_modal;
            }
        }

        $orders_edit = json_encode($orders);
    }
}

?>
