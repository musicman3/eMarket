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
            $name_edit_temp[$x][$modal_id] = $PDO->selectPrepare("SELECT name FROM " . TABLE_CURRENCIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
            $code_edit_temp[$x][$modal_id] = $PDO->selectPrepare("SELECT code FROM " . TABLE_CURRENCIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$x]]);
        }
        
        $iso_4217_edit_temp[$modal_id] = $PDO->selectPrepare("SELECT iso_4217 FROM " . TABLE_CURRENCIES . " WHERE id=?", [$modal_id]);
        $value_edit_temp[$modal_id] = (float)$PDO->selectPrepare("SELECT value FROM " . TABLE_CURRENCIES . " WHERE id=?", [$modal_id]);
        $symbol_edit_temp[$modal_id] = $PDO->selectPrepare("SELECT symbol FROM " . TABLE_CURRENCIES . " WHERE id=?", [$modal_id]);
        $symbol_position_edit_temp[$modal_id] = $PDO->selectPrepare("SELECT symbol_position FROM " . TABLE_CURRENCIES . " WHERE id=?", [$modal_id]);
        $decimal_places_edit_temp[$modal_id] = (float)$PDO->selectPrepare("SELECT decimal_places FROM " . TABLE_CURRENCIES . " WHERE id=?", [$modal_id]);
        $status_value_edit_temp[$modal_id] = (int) $PDO->selectPrepare("SELECT default_value FROM " . TABLE_CURRENCIES . " WHERE id=?", [$modal_id]);
        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit = json_encode($name_edit_temp); // Имя
        $code_edit = json_encode($code_edit_temp); // Короткое имя
        $iso_4217_edit = json_encode($iso_4217_edit_temp); // iso 4217
        $value_edit = json_encode($value_edit_temp); // Значение
        $symbol_edit = json_encode($symbol_edit_temp); // Символ
        $symbol_position_edit = json_encode($symbol_position_edit_temp); // Позиция символа
        $decimal_places_edit = json_encode($decimal_places_edit_temp); // Кол-во десятичных знаков
        $status_value_edit = json_encode($status_value_edit_temp); // Статус
    }
}
if (!isset($modal_id)) {
    $modal_id = 'false';
}
?>
