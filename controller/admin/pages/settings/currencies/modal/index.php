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
            $query_lang = $name_temp[$x][$modal_id] = \eMarket\Pdo::getRow("SELECT name, code FROM " . TABLE_CURRENCIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $name_temp[$x][$modal_id] = $query_lang[0];
            $code_temp[$x][$modal_id] = $query_lang[1];
        }
        $query = \eMarket\Pdo::getRow("SELECT iso_4217, value, symbol, symbol_position, decimal_places, default_value FROM " . TABLE_CURRENCIES . " WHERE id=?", [$modal_id]);
        $iso_4217_temp[$modal_id] = $query[0];
        $value_temp[$modal_id] = (float) $query[1];
        $symbol_temp[$modal_id] = $query[2];
        $symbol_position_temp[$modal_id] = $query[3];
        $decimal_places_temp[$modal_id] = (float) $query[4];
        $status_value_temp[$modal_id] = (int) $query[5];
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name = json_encode($name_temp); // Имя
        $code = json_encode($code_temp); // Короткое имя
        $iso_4217 = json_encode($iso_4217_temp); // iso 4217
        $value = json_encode($value_temp); // Значение
        $symbol = json_encode($symbol_temp); // Символ
        $symbol_position = json_encode($symbol_position_temp); // Позиция символа
        $decimal_places = json_encode($decimal_places_temp); // Кол-во десятичных знаков
        $status_value = json_encode($status_value_temp); // Статус
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
