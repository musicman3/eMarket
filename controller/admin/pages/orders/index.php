<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {
    
    $primary_language = \eMarket\Set::primaryLanguage();
    // Сохраняем статус
    $customer_status_history_select = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE language=? AND id=?", [lang('#lang_all')[0], \eMarket\Valid::inPOST('status_history_select')]);
    $admin_status_history_select = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE language=? AND id=?", [$primary_language, \eMarket\Valid::inPOST('status_history_select')]);
    $status_history_data = json_decode(\eMarket\Pdo::getCellFalse("SELECT orders_status_history FROM " . TABLE_ORDERS . " WHERE id=?", [\eMarket\Valid::inPOST('edit')]), 1);
    array_push($status_history_data['customer'], $customer_status_history_select);
    array_push($status_history_data['admin'], $admin_status_history_select);
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_ORDERS . " SET orders_status_history=?, last_modified=? WHERE id=?", [json_encode($status_history_data), date("Y-m-d H:i:s"), \eMarket\Valid::inPOST('edit')]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {
    // Удаляем запись
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_ORDERS . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

$order_status = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_ORDERS . " ORDER BY id DESC", []);
$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//\eMarket\Debug::trace($unit = \eMarket\Pdo::getColAssoc("SELECT id, name FROM " . TABLE_UNITS . " WHERE language=?", [lang('#lang_all')[0]]));
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>