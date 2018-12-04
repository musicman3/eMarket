<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// собираем данные для отображения в Редактировании
if (isset($lines[$k][0]) == TRUE) {
    $name_edit = array();
    $value_edit = array();
    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        array_push($name_edit, $PDO->selectPrepare("SELECT name FROM " . TABLE_UNITS . " WHERE id=? and language=?", [$lines[$k][0], lang('#lang_all')[$xl]]));
        array_push($value_edit, $PDO->selectPrepare("SELECT unit FROM " . TABLE_UNITS . " WHERE id=? and language=?", [$lines[$k][0], lang('#lang_all')[$xl]]));
    }

}

?>
