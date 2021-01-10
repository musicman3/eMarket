<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$json_data = json_encode([]);
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i]['id']) == TRUE) {

        $modal_id = $lines[$i]['id'];

        foreach ($sql_data as $sql_modal) {
            if ($sql_modal['id'] == $modal_id) {
                $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                $code[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['code'];
            }
            if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                $value_length[$modal_id] = (float) $sql_modal['value_length'];
                $default_length[$modal_id] = (int) $sql_modal['default_length'];
            }
        }

        ksort($name);
        ksort($code);

        $json_data = json_encode([
            'name' => $name,
            'code' => $code,
            'value_length' => $value_length,
            'default_length' => $default_length
        ]);
    }
}
?>
