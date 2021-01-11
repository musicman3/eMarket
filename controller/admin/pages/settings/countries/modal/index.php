<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$json_data = json_encode([]);
for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
    if (isset($lines[$i]['id']) == TRUE) {

        $modal_id = $lines[$i]['id'];

        foreach ($sql_data as $sql_modal) {
            if ($sql_modal['id'] == $modal_id) {
                $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
            }
            if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                $alpha_2[$modal_id] = $sql_modal['alpha_2'];
                $alpha_3[$modal_id] = $sql_modal['alpha_3'];
                $address_format[$modal_id] = $sql_modal['address_format'];
            }
        }

        ksort($name);

        $json_data = json_encode([
            'name' => $name,
            'alpha_2' => $alpha_2,
            'alpha_3' => $alpha_3,
            'address_format' => $address_format
        ]);
    }
}
?>
