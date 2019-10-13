<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// Если нажали на кнопку Добавить
if (\eMarket\Core\Valid::inPOST('add')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Core\Valid::inPOST('default_length')) {
        $default_length = 1;
    } else {
        $default_length = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_LENGTH . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_length != 0) {
        \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

        //Пересчитываем значения
        $value_length_all = \eMarket\Core\Pdo::getColAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
        $count_value_length_all = count($value_length_all);
        for ($x = 0; $x < $count_value_length_all; $x++) {
            \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [($value_length_all[$x]['value_length'] / \eMarket\Core\Valid::inPOST('value_length')), $value_length_all[$x]['id'], $value_length_all[$x]['language']]);
        }
        
        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [$id, \eMarket\Core\Valid::inPOST('name_length_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('code_length_' . $x), 1, $default_length]);
        }
    } else {

        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [$id, \eMarket\Core\Valid::inPOST('name_length_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('code_length_' . $x), \eMarket\Core\Valid::inPOST('value_length'), $default_length]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Редактировать
if (\eMarket\Core\Valid::inPOST('edit')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Core\Valid::inPOST('default_length_edit')) {
        $default_length = 1;
    } else {
        $default_length = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_length != 0) {
        \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

        //Пересчитываем значения
        $value_length_all = \eMarket\Core\Pdo::getColAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
        $count_value_length_all = count($value_length_all);
        for ($x = 0; $x < $count_value_length_all; $x++) {
            \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [($value_length_all[$x]['value_length'] / \eMarket\Core\Valid::inPOST('value_length_edit')), $value_length_all[$x]['id'], $value_length_all[$x]['language']]);
        }

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_length_edit_' . $x), \eMarket\Core\Valid::inPOST('code_length_edit_' . $x), 1, $default_length, \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    } else {

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_length_edit_' . $x), \eMarket\Core\Valid::inPOST('code_length_edit_' . $x), \eMarket\Core\Valid::inPOST('value_length_edit'), $default_length, \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if (\eMarket\Core\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_LENGTH . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Core\Pdo::getColRow("SELECT id, name, code, value_length, default_length FROM " . TABLE_LENGTH . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Core\Set::linesOnPage();
$navigate = \eMarket\Core\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>