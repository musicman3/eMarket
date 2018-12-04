<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// собираем данные для отображения в Редактировании категорий
if (isset($lines[$k][0]) == TRUE) {
    $name_category_edit = array();
    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        array_push($name_category_edit, $PDO->selectPrepare("SELECT name FROM " . TABLE_CATEGORIES . " WHERE id=? and language=?", [$lines[$k][0], lang('#lang_all')[$xl]]));
    }

    $status_category_edit = $PDO->selectPrepare("SELECT status FROM " . TABLE_CATEGORIES . " WHERE id=?", [$lines[$k][0]]);

    if ($status_category_edit == 1) {
        $status_category_edit = 'checked';
    } else {
        $status_category_edit = '';
    }
}

?>
