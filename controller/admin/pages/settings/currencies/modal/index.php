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
        
        foreach ($sql_data as $sql_modal) {
            //Языковые
            if ($sql_modal['id'] == $modal_id) {
                $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                $code[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['code'];
            }
            if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                $iso_4217[$modal_id] = $sql_modal['iso_4217'];
                $value[$modal_id] = $sql_modal['value'];
                $symbol[$modal_id] = $sql_modal['symbol'];
                $symbol_position[$modal_id] = $sql_modal['symbol_position'];
                $decimal_places[$modal_id] = $sql_modal['decimal_places'];
                $default_value[$modal_id] = $sql_modal['default_value'];
            }
        }
        //Сортируем языковые
        ksort($name);
        ksort($code);
        
        $json_data = json_encode([
            'name' => $name,
            'code' => $code,
            'iso_4217' => $iso_4217,
            'value' => $value,
            'symbol' => $symbol,
            'symbol_position' => $symbol_position,
            'decimal_places' => $decimal_places,
            'default_value' => $default_value
        ]);
    }
}

?>
