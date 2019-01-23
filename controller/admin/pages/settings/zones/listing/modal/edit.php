<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// собираем данные для отображения в Редактировании
if (isset($lines[$k][0]) == TRUE) {
    $name_edit = [];
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        array_push($name_edit, $PDO->selectPrepare("SELECT name FROM " . TABLE_ZONES . " WHERE id=? and language=?", [$lines[$k][0], lang('#lang_all')[$x]]));
    }
    $value_edit = $PDO->selectPrepare("SELECT note FROM " . TABLE_ZONES . " WHERE id=?", [$lines[$k][0]]);

}

?>
