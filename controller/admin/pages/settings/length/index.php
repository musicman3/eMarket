<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_length')) {
        $default_length = 1;
    } else {
        $default_length = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_LENGTH . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_length != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

        //Пересчитываем значения
        $value_length_all = \eMarket\Pdo::getColAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
        $count_value_length_all = count($value_length_all);
        for ($x = 0; $x < $count_value_length_all; $x++) {
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [($value_length_all[$x]['value_length'] / \eMarket\Valid::inPOST('value_length')), $value_length_all[$x]['id'], $value_length_all[$x]['language']]);
        }
        
        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [$id, \eMarket\Valid::inPOST('name_length_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_length_' . $x), 1, $default_length]);
        }
    } else {

        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [$id, \eMarket\Valid::inPOST('name_length_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_length_' . $x), \eMarket\Valid::inPOST('value_length'), $default_length]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_length')) {
        $default_length = 1;
    } else {
        $default_length = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_length != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

        //Пересчитываем значения
        $value_length_all = \eMarket\Pdo::getColAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
        $count_value_length_all = count($value_length_all);
        for ($x = 0; $x < $count_value_length_all; $x++) {
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [($value_length_all[$x]['value_length'] / \eMarket\Valid::inPOST('value_length')), $value_length_all[$x]['id'], $value_length_all[$x]['language']]);
        }

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_length_' . $x), \eMarket\Valid::inPOST('code_length_' . $x), 1, $default_length, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    } else {

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_length_' . $x), \eMarket\Valid::inPOST('code_length_' . $x), \eMarket\Valid::inPOST('value_length'), $default_length, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_LENGTH . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT id, name, code, value_length, default_length FROM " . TABLE_LENGTH . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Set::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

// Модальное окно
require_once('modal/index.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>