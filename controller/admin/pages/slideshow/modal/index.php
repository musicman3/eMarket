<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$json_data = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i]['id']) == TRUE) {

        $modal_id = $lines[$i]['id']; // ID

        foreach ($sql_data as $sql_modal) {
            if ($sql_modal['id'] == $modal_id) {
                $name[$modal_id] = $sql_modal['name'];
                $url[$modal_id] = $sql_modal['url'];
                $heading[$modal_id] = $sql_modal['heading'];
                $logo[$modal_id] = json_decode($sql_modal['logo'], 1);
                $logo_general[$modal_id] = $sql_modal['logo_general'];
                $heading[$modal_id] = $sql_modal['heading'];
                $date_start[$modal_id] = $sql_modal['date_start'];
                $date_finish[$modal_id] = $sql_modal['date_finish'];
                $status[$modal_id] = (int) $sql_modal['status'];
            }
        }

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
