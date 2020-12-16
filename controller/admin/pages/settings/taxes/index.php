<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    if (\eMarket\Valid::inPOST('tax_type')) {
        $tax_type = 1;
    } else {
        $tax_type = 0;
    }

    if (\eMarket\Valid::inPOST('fixed')) {
        $fixed = 1;
    } else {
        $fixed = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_TAXES . " SET id=?, name=?, language=?, rate=?, tax_type=?, zones_id=?, fixed=?, currency=?", [$id, \eMarket\Valid::inPOST('name_taxes_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('rate_taxes'), $tax_type, \eMarket\Valid::inPOST('zones_id'), $fixed, \eMarket\Set::currencyDefault()[0]]);
    }

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {

    if (\eMarket\Valid::inPOST('tax_type')) {
        $tax_type = 1;
    } else {
        $tax_type = 0;
    }

    if (\eMarket\Valid::inPOST('fixed')) {
        $fixed = 1;
    } else {
        $fixed = 0;
    }

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        // обновляем запись
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_TAXES . " SET name=?, rate=?, tax_type=?, zones_id=?, fixed=?, currency=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_taxes_' . $x), \eMarket\Valid::inPOST('rate_taxes'), $tax_type, \eMarket\Valid::inPOST('zones_id'), $fixed, \eMarket\Set::currencyDefault()[0], \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_TAXES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$zones = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ZONES . " WHERE language=?", [lang('#lang_all')[0]]);

$zones_names = [];
foreach ($zones as $zones_val) {
    $zones_names[$zones_val['id']] = $zones_val['name'];
}

$value_6 = [0 => sprintf(lang('taxes_value'), \eMarket\Set::currencyDefault()[2]), 1 => lang('taxes_percent')];
$value_4 = [0 => lang('taxes_separately'), 1 => lang('taxes_included')];

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_TAXES . " ORDER BY id DESC", []);
$lines = \eMarket\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
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