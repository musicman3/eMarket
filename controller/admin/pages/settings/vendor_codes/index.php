<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
// 
// Если нажали на кнопку Добавить
if ($VALID->inGET('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_VENDOR_CODES . " WHERE language=? ORDER BY id DESC", [$LANG_ALL[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count($LANG_ALL); $xl++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_VENDOR_CODES . " SET id=?, name=?, language=?, vendor_code=?", [$id, $VALID->inGET($SET->titleDir() . '_' . $LANG_ALL[$xl]), $LANG_ALL[$xl], $VALID->inGET('vendor_code' . $LANG_ALL[$xl])]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('id_edit')) {

    for ($xl = 0; $xl < count($LANG_ALL); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_VENDOR_CODES . " SET name=?, vendor_code=? WHERE id=? AND language=?", [$VALID->inGET('name_edit_' . $SET->titleDir() . '_' . $LANG_ALL[$xl]), $VALID->inGET('vendor_code_edit' . $LANG_ALL[$xl]), $VALID->inGET('id_edit'), $LANG_ALL[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_VENDOR_CODES . " WHERE id=?", [$VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, vendor_code FROM " . TABLE_VENDOR_CODES . " WHERE language=? ORDER BY id DESC", [$LANG_ALL[0]]);
$navigate = $NAVIGATION->getLink(count($lines), $SET->linesOnPage());
$start = $navigate[0];
$finish = $navigate[1];

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */

?>