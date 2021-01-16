<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$MODULE_DB = \eMarket\Core\Settings::moduleDatabase();

// Если нажали на кнопку Добавить
if (\eMarket\Core\Valid::inPOST('add')) {
    // Формат даты после Datepicker
    if (\eMarket\Core\Valid::inPOST('start_date')) {
        $start_date = date('Y-m-d', strtotime(\eMarket\Core\Valid::inPOST('start_date')));
    } else {
        $start_date = NULL;
    }
    // Формат даты после Datepicker
    if (\eMarket\Core\Valid::inPOST('end_date')) {
        $end_date = date('Y-m-d', strtotime(\eMarket\Core\Valid::inPOST('end_date')));
    } else {
        $end_date = NULL;
    }

    // Если есть установка по-умолчанию
    if (\eMarket\Core\Valid::inPOST('default_module')) {
        $default_value = 1;
    } else {
        $default_value = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . $MODULE_DB . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_value != 0) {
        \eMarket\Core\Pdo::action("UPDATE " . $MODULE_DB . " SET default_set=?", [0]);
    }

    // добавляем запись для всех вкладок
    for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
        \eMarket\Core\Pdo::action("INSERT INTO " . $MODULE_DB . " SET id=?, name=?, language=?, sale_value=?, date_start=?, date_end=?, default_set=?", [$id, \eMarket\Core\Valid::inPOST('name_module_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('sale_value'), $start_date, $end_date, $default_value]);
    }

    // Выводим сообщение об успехе
    \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Редактировать
if (\eMarket\Core\Valid::inPOST('edit')) {
    // Формат даты после Datepicker
    if (\eMarket\Core\Valid::inPOST('start_date')) {
        $start_date = date('Y-m-d', strtotime(\eMarket\Core\Valid::inPOST('start_date')));
    } else {
        $start_date = NULL;
    }
    if (\eMarket\Core\Valid::inPOST('end_date')) {
        $end_date = date('Y-m-d', strtotime(\eMarket\Core\Valid::inPOST('end_date')));
    } else {
        $end_date = NULL;
    }

    // Если есть установка по-умолчанию
    if (\eMarket\Core\Valid::inPOST('default_module')) {
        $default_value = 1;
    } else {
        $default_value = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_value != 0) {
        \eMarket\Core\Pdo::action("UPDATE " . $MODULE_DB . " SET default_set=?", [0]);
    }

    // добавляем запись для всех вкладок
    for ($x = 0; $x < \eMarket\Core\Lang::$COUNT; $x++) {
        \eMarket\Core\Pdo::action("UPDATE " . $MODULE_DB . " SET name=?, sale_value=?, date_start=?, date_end=?, default_set=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_module_' . $x), \eMarket\Core\Valid::inPOST('sale_value'), $start_date, $end_date, $default_value, \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Удалить
if (\eMarket\Core\Valid::inPOST('delete')) {

    // Удаляем
    $discount_id_array = \eMarket\Core\Pdo::getCol("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=?", [lang('#lang_all')[0]]);

    foreach ($discount_id_array as $discount_id_arr) {
        $discount_str_temp = \eMarket\Core\Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$discount_id_arr]);
        $discount_str_explode_temp = explode(',', $discount_str_temp);
        $discount_str_explode = \eMarket\Core\Func::deleteValInArray(\eMarket\Core\Func::deleteEmptyInArray($discount_str_explode_temp), [\eMarket\Core\Valid::inPOST('delete')]);
        $discount_str_implode = implode(',', $discount_str_explode);
        \eMarket\Core\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [$discount_str_implode, $discount_id_arr]);
    }

    \eMarket\Core\Pdo::action("DELETE FROM " . $MODULE_DB . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$sql_data = \eMarket\Core\Pdo::getColAssoc("SELECT *, UNIX_TIMESTAMP (date_end) FROM " . $MODULE_DB . " ORDER BY id DESC", []);
$lines = \eMarket\Core\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
$lines_on_page = \eMarket\Core\Settings::linesOnPage();
$navigate = \eMarket\Core\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

$this_time = time();

require(\eMarket\Core\View::routingModules('controller') . '/modal/index.php');

\eMarket\Core\Settings::jsModulesHandler();
// Загружаем разметку модуля
require_once (\eMarket\Core\View::routingModules('view') . '/index.php');
?>