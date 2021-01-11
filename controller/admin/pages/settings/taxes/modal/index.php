<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$json_data = json_encode(['zones' => $zones]);
for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
    if (isset($lines[$i]['id']) == TRUE) {

        $modal_id = $lines[$i]['id'];

        foreach ($sql_data as $sql_modal) {
            if ($sql_modal['id'] == $modal_id) {
                $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
            }
            if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                $rate[$modal_id] = round($sql_modal['rate'], 2);
                $tax_type_modal[$modal_id] = (int) $sql_modal['tax_type'];
                $zones_id[$modal_id] = (int) $sql_modal['zones_id'];
                $fixed_modal[$modal_id] = (int) $sql_modal['fixed'];
            }
        }

        ksort($name);
        $json_data = json_encode([
            'name' => $name,
            'rate' => $rate,
            'tax_type' => $tax_type_modal,
            'zones_id' => $zones_id,
            'fixed' => $fixed_modal,
            'zones' => $zones
        ]);
    }
}
?>
