<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_vendor_code')) {
        $default_vendor_code = 1;
    } else {
        $default_vendor_code = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_VENDOR_CODES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_vendor_code != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_VENDOR_CODES . " SET default_vendor_code=?", [0]);
    }

    // добавляем запись для всех вкладок
    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_VENDOR_CODES . " SET id=?, name=?, language=?, vendor_code=?, default_vendor_code=?", [$id, \eMarket\Valid::inPOST('name_vendor_codes_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('vendor_code_' . $x), $default_vendor_code]);
    }

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_vendor_code')) {
        $default_vendor_code = 1;
    } else {
        $default_vendor_code = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_vendor_code != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_VENDOR_CODES . " SET default_vendor_code=?", [0]);
    }

    for ($x = 0; $x < \eMarket\Lang::$COUNT; $x++) {
        // обновляем запись
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_VENDOR_CODES . " SET name=?, vendor_code=?, default_vendor_code=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_vendor_codes_' . $x), \eMarket\Valid::inPOST('vendor_code_' . $x), $default_vendor_code, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_VENDOR_CODES . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_VENDOR_CODES . " ORDER BY id DESC", []);
$lines = \eMarket\Func::filterData($sql_data, 'language', lang('#lang_all')[0]);
$lines_on_page = \eMarket\Set::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

// Модальное окно
require_once('modal/index.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
\eMarket\Set::$JS_END = __DIR__;

?>