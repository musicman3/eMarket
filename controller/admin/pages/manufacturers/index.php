<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если нажали на кнопку Добавить
if (\eMarket\Core\Valid::inPOST('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_MANUFACTURERS . " SET id=?, name=?, language=?, site=?", [$id, \eMarket\Core\Valid::inPOST('name_manufacturers_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('site_manufacturers')]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Редактировать
if (\eMarket\Core\Valid::inPOST('edit')) {

    for ($x = 0; $x < $LANG_COUNT; $x++) {
        \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_MANUFACTURERS . " SET name=?, site=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_manufacturers_edit_' . $x), \eMarket\Core\Valid::inPOST('site_manufacturers_edit'), \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Загручик изображений (ВСТАВЛЯТЬ ПЕРЕД УДАЛЕНИЕМ)
$resize_param = [];
array_push($resize_param, ['125', '94']); // ширина, высота
//array_push($resize_param, ['200','150']);
//array_push($resize_param, ['325','244']);
//array_push($resize_param, ['525','394']);
//array_push($resize_param, ['850','638']);

$FILES->imgUpload(TABLE_MANUFACTURERS, 'manufacturers', $resize_param);

// Если нажали на кнопку Удалить
if (\eMarket\Core\Valid::inPOST('delete')) {
    // Удаляем запись
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_MANUFACTURERS . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Core\Pdo::getColRow("SELECT id, name, logo, site FROM " . TABLE_MANUFACTURERS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Core\Set::linesOnPage();
$navigate = \eMarket\Core\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>