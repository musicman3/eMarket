<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// 
//Сохраняем сессию с URL текущей страницы
$_SESSION['country_page'] = \eMarket\Valid::inSERVER('REQUEST_URI');

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_COUNTRIES . " SET id=?, name=?, language=?, alpha_2=?, alpha_3=?, address_format=?", [$id, \eMarket\Valid::inPOST('name_countries_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('alpha_2_countries'), \eMarket\Valid::inPOST('alpha_3_countries'), \eMarket\Valid::inPOST('address_format_countries')]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {

    for ($x = 0; $x < $LANG_COUNT; $x++) {
        // обновляем запись
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_COUNTRIES . " SET name=?, alpha_2=?, alpha_3=?, address_format=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_countries_' . $x), \eMarket\Valid::inPOST('alpha_2_countries'), \eMarket\Valid::inPOST('alpha_3_countries'), \eMarket\Valid::inPOST('address_format_countries'), \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    // Удаляем Страну и Регионы
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_COUNTRIES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT id, name, alpha_2, alpha_3 FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY name", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

// Модальное окно
require_once('modal/index.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>