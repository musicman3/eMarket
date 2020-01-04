<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$MODULE_DB = \eMarket\Set::moduleDatabase();

$zones = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ZONES . " WHERE language=?", [lang('#lang_all')[0]]);

$zones_name = [];
foreach ($zones as $val){
    $zones_name[$val['id']] = $val['name'];
}

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {
    \eMarket\Pdo::inPrepare("INSERT INTO " . $MODULE_DB . " SET minimum_price=?, shipping_zone=?", [\eMarket\Valid::inPOST('minimum_price'), \eMarket\Valid::inPOST('zone')]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {
    \eMarket\Pdo::inPrepare("UPDATE " . $MODULE_DB . " SET minimum_price=?, shipping_zone=? WHERE id=?", [\eMarket\Valid::inPOST('minimum_price_edit'), \eMarket\Valid::inPOST('zone_edit'), \eMarket\Valid::inPOST('edit')]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {
        // Удаляем Страну и Регионы
    \eMarket\Pdo::inPrepare("DELETE FROM " . $MODULE_DB . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT * FROM " . $MODULE_DB . " ORDER BY id DESC", []);
$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_MOD_END = __DIR__;
// Загружаем разметку модуля
require_once (\eMarket\View::routingModules('view') . '/index.php');
?>