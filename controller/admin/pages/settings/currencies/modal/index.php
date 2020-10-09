<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// собираем данные для отображения в Редактировании
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID
        $count_lang = $LANG_COUNT;

        for ($x = 0; $x < $count_lang; $x++) {
            $query_lang = \eMarket\Pdo::getRow("SELECT name, code FROM " . TABLE_CURRENCIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $name[$x][$modal_id] = $query_lang[0];
            $code[$x][$modal_id] = $query_lang[1];
        }
        $query = \eMarket\Pdo::getRow("SELECT iso_4217, value, symbol, symbol_position, decimal_places, default_value FROM " . TABLE_CURRENCIES . " WHERE id=?", [$modal_id]);
        $iso_4217[$modal_id] = $query[0];
        $value[$modal_id] = (float) $query[1];
        $symbol[$modal_id] = $query[2];
        $symbol_position[$modal_id] = $query[3];
        $decimal_places[$modal_id] = (float) $query[4];
        $status[$modal_id] = (int) $query[5];
        
        $json_data = json_encode([
            'name' => $name,
            'code' => $code,
            'iso_4217' => $iso_4217,
            'value' => $value,
            'symbol' => $symbol,
            'symbol_position' => $symbol_position,
            'decimal_places' => $decimal_places,
            'status' => $status
        ]);
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
    $name = ''; // Имя
    $code = ''; // Короткое имя
    $iso_4217 = ''; // iso 4217
    $value = ''; // Значение
    $symbol = ''; // Символ
    $symbol_position = ''; // Позиция символа
    $decimal_places = ''; // Кол-во десятичных знаков
    $status_value = ''; // Статус
}

?>
