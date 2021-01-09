<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$MODULE_DB = \eMarket\Settings::moduleDatabase();

$zones = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ZONES . " WHERE language=?", [lang('#lang_all')[0]]);

$zones_name = [];
foreach ($zones as $val) {
    $zones_name[$val['id']] = $val['name'];
}

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {
    \eMarket\Pdo::action("INSERT INTO " . $MODULE_DB . " SET minimum_price=?, shipping_zone=?, currency=?", [\eMarket\Valid::inPOST('minimum_price'), \eMarket\Valid::inPOST('zone'), \eMarket\Settings::currencyDefault()[0]]);

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
    exit;
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {
    \eMarket\Pdo::action("UPDATE " . $MODULE_DB . " SET minimum_price=?, shipping_zone=?, currency=? WHERE id=?", [\eMarket\Valid::inPOST('minimum_price'), \eMarket\Valid::inPOST('zone'), \eMarket\Settings::currencyDefault()[0], \eMarket\Valid::inPOST('edit')]);

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
    exit;
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {
    \eMarket\Pdo::action("DELETE FROM " . $MODULE_DB . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    
    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
    exit;
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT * FROM " . $MODULE_DB . " ORDER BY id DESC", []);
$lines_on_page = \eMarket\Settings::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

require(\eMarket\View::routingModules('controller') . '/modal/index.php');

\eMarket\Settings::jsModulesHandler();
// Загружаем разметку модуля
require_once (\eMarket\View::routingModules('view') . '/index.php');
?>