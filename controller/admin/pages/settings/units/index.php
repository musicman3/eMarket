<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// 
// Если нажали на кнопку Добавить
if ($VALID->inPOST('add')) {

    // Если есть установка по-умолчанию
    if ($VALID->inPOST('default_unit')) {
        $default_unit = 1;
    } else {
        $default_unit = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_UNITS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_unit != 0) {
        \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_UNITS . " SET default_unit=?", [0]);
    }

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_UNITS . " SET id=?, name=?, language=?, unit=?, default_unit=?", [$id, $VALID->inPOST('name_units_' . $x), lang('#lang_all')[$x], $VALID->inPOST('unit_units_' . $x), $default_unit]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {

    // Если есть установка по-умолчанию
    if ($VALID->inPOST('default_unit_edit')) {
        $default_unit = 1;
    } else {
        $default_unit = 0;
    }
    // Оставляем один экземпляр значения по-умолчанию
    if ($default_unit != 0) {
        \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_UNITS . " SET default_unit=?", [0]);
    }

    for ($x = 0; $x < $LANG_COUNT; $x++) {
        // обновляем запись
        \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_UNITS . " SET name=?, unit=?, default_unit=? WHERE id=? AND language=?", [$VALID->inPOST('name_units_edit_' . $x), $VALID->inPOST('unit_units_edit_' . $x), $default_unit, $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_UNITS . " WHERE id=?", [$VALID->inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Core\Pdo::getColRow("SELECT id, name, unit, default_unit FROM " . TABLE_UNITS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = $SET->linesOnPage();
$navigate = $NAVIGATION->getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>