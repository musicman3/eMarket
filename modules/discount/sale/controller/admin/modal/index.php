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
            //Языковые
            if ($sql_modal['id'] == $modal_id) {
                $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
            }
            if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                $sale_value[$modal_id] = (float) $sql_modal['sale_value'];
                $date_start[$modal_id] = $sql_modal['date_start'];
                $date_end[$modal_id] = $sql_modal['date_end'];
                $default_set[$modal_id] = $sql_modal['default_set'];
            }
        }
        //Сортируем языковые
        ksort($name);
        
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $json_data = json_encode([
            'name' => $name,
            'value' => $sale_value,
            'start' => $date_start,
            'end' => $date_end,
            'default' => $default_set
        ]);
    }
}

?>
