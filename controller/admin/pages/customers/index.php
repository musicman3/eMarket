<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если нажали на кнопку Статус
if (\eMarket\Valid::inPOST('status')) {

    $status_data = \eMarket\Pdo::getCell("SELECT status FROM " . TABLE_CUSTOMERS . " WHERE id=?", [\eMarket\Valid::inPOST('status')]);

    if ($status_data == 0) {
        $status = 1;
    } else {
        $status = 0;
    }
    
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [$status, \eMarket\Valid::inPOST('status')]);

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {
    // Удаляем запись
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_CUSTOMERS . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$search = '%' . \eMarket\Valid::inGET('search') . '%';
if (\eMarket\Valid::inGET('search')) {
    $lines = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE firstname LIKE? OR lastname LIKE? OR middle_name LIKE? OR email LIKE? ORDER BY id DESC", [$search, $search, $search, $search]);
} else {
    $lines = \eMarket\Pdo::getColRow("SELECT * FROM " . TABLE_CUSTOMERS . " ORDER BY id DESC", []);
}
$lines_on_page = \eMarket\Set::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>