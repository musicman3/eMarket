<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_value_currencies')) {
        $default_value = 1;
    } else {
        $default_value = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_CURRENCIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_value != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

        //Пересчитываем значения
        $value_all = \eMarket\Pdo::getColAssoc("SELECT id, value, language FROM " . TABLE_CURRENCIES, []);
        $count_value_all = count($value_all);
        for ($x = 0; $x < $count_value_all; $x++) {
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [($value_all[$x]['value'] / \eMarket\Valid::inPOST('value_currencies')), $value_all[$x]['id'], $value_all[$x]['language']]);
        }
        
        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?", [$id, \eMarket\Valid::inPOST('name_currencies_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_currencies_' . $x), \eMarket\Valid::inPOST('iso_4217_currencies'), 1, $default_value, \eMarket\Valid::inPOST('symbol_currencies'), \eMarket\Valid::inPOST('symbol_position_currencies'), \eMarket\Valid::inPOST('decimal_places_currencies')]);
        }
    } else {

        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?", [$id, \eMarket\Valid::inPOST('name_currencies_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_currencies_' . $x), \eMarket\Valid::inPOST('iso_4217_currencies'), \eMarket\Valid::inPOST('value_currencies'), $default_value, \eMarket\Valid::inPOST('symbol_currencies'), \eMarket\Valid::inPOST('symbol_position_currencies'), \eMarket\Valid::inPOST('decimal_places_currencies')]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_value_currencies_edit')) {
        $default_value = 1;
    } else {
        $default_value = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_value != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

        //Пересчитываем значения
        $value_all = \eMarket\Pdo::getColAssoc("SELECT id, value, language FROM " . TABLE_CURRENCIES, []);
        $count_value_all = count($value_all);
        for ($x = 0; $x < $count_value_all; $x++) {
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [($value_all[$x]['value'] / \eMarket\Valid::inPOST('value_currencies_edit')), $value_all[$x]['id'], $value_all[$x]['language']]);
        }

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?, last_updated=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_currencies_edit_' . $x), \eMarket\Valid::inPOST('code_currencies_edit_' . $x), \eMarket\Valid::inPOST('iso_4217_currencies_edit'), 1, $default_value, \eMarket\Valid::inPOST('symbol_currencies_edit'), \eMarket\Valid::inPOST('symbol_position_currencies_edit'), \eMarket\Valid::inPOST('decimal_places_currencies_edit'), date("Y-m-d H:i:s"), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    } else {

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, iso_4217=?, value=?, default_value=?, symbol=?, symbol_position=?, decimal_places=?, last_updated=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_currencies_edit_' . $x), \eMarket\Valid::inPOST('code_currencies_edit_' . $x), \eMarket\Valid::inPOST('iso_4217_currencies_edit'), \eMarket\Valid::inPOST('value_currencies_edit'), $default_value, \eMarket\Valid::inPOST('symbol_currencies_edit'), \eMarket\Valid::inPOST('symbol_position_currencies_edit'), \eMarket\Valid::inPOST('decimal_places_currencies_edit'), date("Y-m-d H:i:s"), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_CURRENCIES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT id, name, code, iso_4217, value, default_value FROM " . TABLE_CURRENCIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>