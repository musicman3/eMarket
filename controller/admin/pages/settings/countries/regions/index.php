<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
// 
// 
if ($VALID->inGET('country_id')) {
    $country_id = $VALID->inGET('country_id');
}
if ($VALID->inPOST('country_id')) {
    $country_id = $VALID->inPOST('country_id');
}
if (!isset($country_id)) {
    $country_id = 0;
}

// Если нажали на кнопку Добавить
if ($VALID->inPOST('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_REGIONS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_REGIONS . " SET id=?, country_id=?, name=?, language=?, region_code=?", [$id, $country_id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$x]), lang('#lang_all')[$x], $VALID->inPOST('region_code')]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {

    for ($x = 0; $x < $LANG_COUNT; $x++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_REGIONS . " SET name=?, region_code=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$x]), $VALID->inPOST('region_code_edit'), $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=? AND id=?", [$country_id, $VALID->inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ

$lines = $PDO->getColRow("SELECT id, region_code, name FROM " . TABLE_REGIONS . " WHERE country_id=? AND language=? ORDER BY name", [$country_id, lang('#lang_all')[0]]);
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