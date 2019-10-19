<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$DATABASE = \eMarket\Set::moduleDatabase();

if (\eMarket\Valid::inPOST('add_mod')) {
    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . $DATABASE . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        \eMarket\Pdo::inPrepare("INSERT INTO " . $DATABASE . " SET id=?, name=?, language=?, sale_value=?, date_start=?, date_end=?", [$id, \eMarket\Valid::inPOST('name_module_' . $x), lang('#lang_all')[$x], \eMarket\Valid::inPOST('sale_value'), \eMarket\Valid::inPOST('start_date'), \eMarket\Valid::inPOST('end_date')]);
    }
    
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT id, name, sale_value, date_start, date_end FROM " . $DATABASE . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_MOD_END = __DIR__;
// Загружаем разметку модуля
require_once (__DIR__ . '../../view/admin.php');

?>