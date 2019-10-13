<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// 
if (\eMarket\Core\Valid::inGET('country_id')) {
    $country_id = \eMarket\Core\Valid::inGET('country_id');
}
if (\eMarket\Core\Valid::inPOST('country_id')) {
    $country_id = \eMarket\Core\Valid::inPOST('country_id');
}
if (!isset($country_id)) {
    $country_id = 0;
}

// Если нажали на кнопку Добавить
if (\eMarket\Core\Valid::inPOST('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_REGIONS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_REGIONS . " SET id=?, country_id=?, name=?, language=?, region_code=?", [$id, $country_id, \eMarket\Core\Valid::inPOST('name_regions_' . $x), lang('#lang_all')[$x], \eMarket\Core\Valid::inPOST('region_code_regions')]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Редактировать
if (\eMarket\Core\Valid::inPOST('edit')) {

    for ($x = 0; $x < $LANG_COUNT; $x++) {
        // обновляем запись
        \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_REGIONS . " SET name=?, region_code=? WHERE id=? AND language=?", [\eMarket\Core\Valid::inPOST('name_regions_edit_' . $x), \eMarket\Core\Valid::inPOST('region_code_region_edit'), \eMarket\Core\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if (\eMarket\Core\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=? AND id=?", [$country_id, \eMarket\Core\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ

$lines = \eMarket\Core\Pdo::getColRow("SELECT id, region_code, name FROM " . TABLE_REGIONS . " WHERE country_id=? AND language=? ORDER BY name", [$country_id, lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Core\Set::linesOnPage();
$navigate = $NAVIGATION->getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>