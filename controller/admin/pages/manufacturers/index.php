<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

// Если нажали на кнопку Добавить
if ($VALID->inPOST('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_MANUFACTURERS . " SET id=?, name=?, language=?, site=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$x]), lang('#lang_all')[$x], $VALID->inPOST('site')]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        $PDO->inPrepare("UPDATE " . TABLE_MANUFACTURERS . " SET name=?, site=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$x]), $VALID->inPOST('site_edit'), $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
    }
}

// Загручик изображений (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ)
$image_max = [];// Прописываем используемые размеры по высоте ['94', '150', '244', '394', '638']
array_push($image_max, [null,'94']);
//array_push($image_max, ['150','150']);

$FILES->imgUpload(TABLE_MANUFACTURERS, 'manufacturers', $image_max);

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {
    // Удаляем запись
    $PDO->inPrepare("DELETE FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [$VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, logo, site FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
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