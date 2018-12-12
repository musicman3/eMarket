<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании
for ($i = $start; $i < $finish; $i++) {
    if (isset($lines[$i][0]) == TRUE) {

        if (count(lang('#lang_all')) >= 1) {
            for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {

                json_encode($name_edit_temp[$xl][$lines[$i][0]] = $PDO->selectPrepare("SELECT name FROM " . TABLE_COUNTRIES . " WHERE id=? and language=?", [$lines[$i][0], lang('#lang_all')[$xl]]));
            }
        }

        $alpha_2_temp[$lines[$i][0]] = $PDO->selectPrepare("SELECT alpha_2 FROM " . TABLE_COUNTRIES . " WHERE id=?", [$lines[$i][0]]);
        $alpha_3_temp[$lines[$i][0]] = $PDO->selectPrepare("SELECT alpha_3 FROM " . TABLE_COUNTRIES . " WHERE id=?", [$lines[$i][0]]);
        $address_format_temp[$lines[$i][0]] = $PDO->selectPrepare("SELECT address_format FROM " . TABLE_COUNTRIES . " WHERE id=?", [$lines[$i][0]]);

        // ПАРАМЕТРЫ ДЛЯ ПЕРЕДАЧИ В МОДАЛ
        $modal_id = $lines[$i][0]; // ID
        $name_edit = json_encode($name_edit_temp); // Имя
        $alpha_2 = json_encode($alpha_2_temp); // Alpha 2
        $alpha_3 = json_encode($alpha_3_temp); // Alpha 3
        $address_format = json_encode($address_format_temp); // Формат адреса
    }
}

?>
