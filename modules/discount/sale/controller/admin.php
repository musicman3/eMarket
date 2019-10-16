<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$DATABASE = \eMarket\Set::moduleDatabase();
$lines = \eMarket\Pdo::getColRow("SELECT id, product_id, name, rate, date_start, date_end, default_sale, sort FROM " . $DATABASE . " ORDER BY sort DESC", []);
$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_MOD_END = __DIR__;
//Создаем маркер для подгрузки кнопок Сохранить/Отмена
$BUTTON_FLAG = 'off';
// Загружаем разметку модуля
require_once (__DIR__ . '../../view/admin.php');

?>