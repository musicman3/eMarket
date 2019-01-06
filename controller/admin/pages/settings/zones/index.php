<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
// 
//Сохраняем сессию с URL текущей страницы
$_SESSION['zone_page'] = '/controller/admin/pages/settings/zones/index.php';

// Если нажали на кнопку Добавить
if ($VALID->inPOST('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_ZONES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $_SESSION['lang_count']; $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_ZONES . " SET id=?, name=?, note=?, language=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$x]), $VALID->inPOST('note'), lang('#lang_all')[$x]]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {

    for ($x = 0; $x < $_SESSION['lang_count']; $x++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_ZONES . " SET name=?, note=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$x]), $VALID->inPOST('note_edit'), $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_ZONES . " WHERE id=?", [$VALID->inPOST('delete')]);
    $PDO->inPrepare("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, note FROM " . TABLE_ZONES . " WHERE language=? ORDER BY name", [lang('#lang_all')[0]]);
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