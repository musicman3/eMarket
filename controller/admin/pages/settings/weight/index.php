<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_weight')) {
        $default_weight = 1;
    } else {
        $default_weight = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_WEIGHT . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_weight != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);

        //Пересчитываем значения
        $value_weight_all = \eMarket\Pdo::getColAssoc("SELECT id, value_weight, language FROM " . TABLE_WEIGHT, []);
        $count_value_weight_all = count($value_weight_all);
        for ($x = 0; $x < $count_value_weight_all; $x++) {
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_WEIGHT . " SET value_weight=? WHERE id=? AND language=?", [($value_weight_all[$x]['value_weight'] / \eMarket\Valid::inPOST('value_weight')), $value_weight_all[$x]['id'], $value_weight_all[$x]['language']]);
        }
        
        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [$id, \eMarket\Valid::inPOST('name_weight_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_weight_' . $x), 1, $default_weight]);
        }
    } else {

        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [$id, \eMarket\Valid::inPOST('name_weight_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('code_weight_' . $x), \eMarket\Valid::inPOST('value_weight'), $default_weight]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_weight')) {
        $default_weight = 1;
    } else {
        $default_weight = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_weight != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);

        //Пересчитываем значения
        $value_weight_all = \eMarket\Pdo::getColAssoc("SELECT id, value_weight, language FROM " . TABLE_WEIGHT, []);
        $count_value_weight_all = count($value_weight_all);
        for ($x = 0; $x < $count_value_weight_all; $x++) {
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_WEIGHT . " SET value_weight=? WHERE id=? AND language=?", [($value_weight_all[$x]['value_weight'] / \eMarket\Valid::inPOST('value_weight')), $value_weight_all[$x]['id'], $value_weight_all[$x]['language']]);
        }

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_weight_' . $x), \eMarket\Valid::inPOST('code_weight_' . $x), 1, $default_weight, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    } else {

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            \eMarket\Pdo::inPrepare("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_weight_' . $x), \eMarket\Valid::inPOST('code_weight_' . $x), \eMarket\Valid::inPOST('value_weight'), $default_weight, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_WEIGHT . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT id, name, code, value_weight, default_weight FROM " . TABLE_WEIGHT . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

// Модальное окно
require_once('modal/index.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>