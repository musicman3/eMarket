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
                $region_code[$modal_id] = $sql_modal['region_code'];
            }
        }

        ksort($name);

        $json_data = json_encode([
            'name' => $name,
            'region_code' => $region_code
        ]);
    }
}
?>
