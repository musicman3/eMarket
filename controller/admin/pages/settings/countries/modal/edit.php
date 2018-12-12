<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        $modal_id = $lines[$i][0]; // ID

        if (count(lang('#lang_all')) >= 1) {
            for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {

                $name_edit_temp[$xl][$modal_id] = $PDO->selectPrepare("SELECT name FROM " . TABLE_COUNTRIES . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[$xl]]);
            }
        }

        $alpha_2_temp[$modal_id] = $PDO->selectPrepare("SELECT alpha_2 FROM " . TABLE_COUNTRIES . " WHERE id=?", [$modal_id]);
        $alpha_3_temp[$modal_id] = $PDO->selectPrepare("SELECT alpha_3 FROM " . TABLE_COUNTRIES . " WHERE id=?", [$modal_id]);
        $address_format_temp[$modal_id] = $PDO->selectPrepare("SELECT address_format FROM " . TABLE_COUNTRIES . " WHERE id=?", [$modal_id]);

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $name_edit = json_encode($name_edit_temp); // Имя
        $alpha_2 = json_encode($alpha_2_temp); // Alpha 2
        $alpha_3 = json_encode($alpha_3_temp); // Alpha 3
        $address_format = json_encode($address_format_temp); // Формат адреса
    }
}

?>
