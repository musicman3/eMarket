<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$MODULE_DB = \eMarket\Core\Settings::moduleDatabase();

$zones = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_ZONES . " WHERE language=?", [lang('#lang_all')[0]]);

$zones_name = [];
foreach ($zones as $val) {
    $zones_name[$val['id']] = $val['name'];
}

// Если нажали на кнопку Добавить
if (\eMarket\Core\Valid::inPOST('add')) {
    \eMarket\Core\Pdo::action("INSERT INTO " . $MODULE_DB . " SET minimum_price=?, shipping_zone=?, currency=?", [\eMarket\Core\Valid::inPOST('minimum_price'), \eMarket\Core\Valid::inPOST('zone'), \eMarket\Core\Settings::currencyDefault()[0]]);

    // Выводим сообщение об успехе
    \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
    exit;
}

// Если нажали на кнопку Редактировать
if (\eMarket\Core\Valid::inPOST('edit')) {
    \eMarket\Core\Pdo::action("UPDATE " . $MODULE_DB . " SET minimum_price=?, shipping_zone=?, currency=? WHERE id=?", [\eMarket\Core\Valid::inPOST('minimum_price'), \eMarket\Core\Valid::inPOST('zone'), \eMarket\Core\Settings::currencyDefault()[0], \eMarket\Core\Valid::inPOST('edit')]);

    // Выводим сообщение об успехе
    \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
    exit;
}

// Если нажали на кнопку Удалить
if (\eMarket\Core\Valid::inPOST('delete')) {
    \eMarket\Core\Pdo::action("DELETE FROM " . $MODULE_DB . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);
    
    // Выводим сообщение об успехе
    \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
    exit;
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Core\Pdo::getColRow("SELECT * FROM " . $MODULE_DB . " ORDER BY id DESC", []);
$lines_on_page = \eMarket\Core\Settings::linesOnPage();
$navigate = \eMarket\Core\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

require(\eMarket\Core\View::routingModules('controller') . '/modal/index.php');

\eMarket\Core\Settings::jsModulesHandler();
// Загружаем разметку модуля
require_once (\eMarket\Core\View::routingModules('view') . '/index.php');
?>