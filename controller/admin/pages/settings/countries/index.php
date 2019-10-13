<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// 
//Сохраняем сессию с URL текущей страницы
$_SESSION['country_page'] = $VALID->inSERVER('REQUEST_URI');

// Если нажали на кнопку Добавить
if ($VALID->inPOST('add')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Core\Pdo::selectPrepare("SELECT id FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_COUNTRIES . " SET id=?, name=?, language=?, alpha_2=?, alpha_3=?, address_format=?", [$id, $VALID->inPOST('name_countries_' . $x), lang('#lang_all')[$x], $VALID->inPOST('alpha_2_countries'), $VALID->inPOST('alpha_3_countries'), $VALID->inPOST('address_format_countries')]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {

    for ($x = 0; $x < $LANG_COUNT; $x++) {
        // обновляем запись
        \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_COUNTRIES . " SET name=?, alpha_2=?, alpha_3=?, address_format=? WHERE id=? AND language=?", [$VALID->inPOST('name_countries_edit_' . $x), $VALID->inPOST('alpha_2_countries_edit'), $VALID->inPOST('alpha_3_countries_edit'), $VALID->inPOST('address_format_countries_edit'), $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем Страну и Регионы
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_COUNTRIES . " WHERE id=?", [$VALID->inPOST('delete')]);
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=?", [$VALID->inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Core\Pdo::getColRow("SELECT id, name, alpha_2, alpha_3 FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY name", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Core\Set::linesOnPage();
$navigate = $NAVIGATION->getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>