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

    if ($VALID->inGET('default_weight')) {
        $status = 1;
    } else {
        $status = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_WEIGHT . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр основного значения
    if ($id > 1 && $status != 0) {
        $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);
    }

    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [$id, $VALID->inGET($SET->titleDir() . '_' . lang('#lang_all')[$xl]), lang('#lang_all')[$xl], $VALID->inGET('code' . lang('#lang_all')[$xl]), $VALID->inGET('value_weight'), $default_weight]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('edit')) {

    if ($VALID->inGET('status_weight_edit')) {
        $status = 1;
    } else {
        $status = 0;
    }

    // Оставляем один экземпляр основного значения
    if ($status != 0) {
        $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);
    }

    for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [$VALID->inGET('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inGET('code_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inGET('value_weight_edit'), $status, $VALID->inGET('edit'), lang('#lang_all')[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_WEIGHT . " WHERE id=?", [$VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, code, value_weight, default_weight FROM " . TABLE_WEIGHT . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = $SET->linesOnPage();
$navigate = $NAVIGATION->getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */
?>