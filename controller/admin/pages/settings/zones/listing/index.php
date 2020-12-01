<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// 
// Получаем zones_id
if (\eMarket\Valid::inPOST('zone_id')) {
    $zones_id = (int) \eMarket\Valid::inPOST('zone_id');
}

if (\eMarket\Valid::inGET('zone_id')) {
    $zones_id = (int) \eMarket\Valid::inGET('zone_id');
}

// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Очищаем страны и регионы из этой зоны
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);

    if (empty(\eMarket\Valid::inPOST('multiselect')) == FALSE) {
        // Создаем многомерный массив из одномерного, разбитого на части разделителем "-"
        $multiselect = \eMarket\Func::arrayExplode(\eMarket\Valid::inPOST('multiselect'), '-');
        // Добавляем выбранные в мультиселекте данные
        for ($x = 0; $x < count($multiselect); $x++) {
            \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_ZONES_VALUE . " SET country_id=?, regions_id=?, zones_id=?", [$multiselect[$x][0], $multiselect[$x][1], $zones_id]);
        }
    }
    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

// Собираем данные для массива Стран в мультиселекте
$countries_multiselect_temp = \eMarket\Pdo::getColRow("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
// Собираем одномерный массив id=>Страна
$countries_multiselect = array_column($countries_multiselect_temp, 1, 0);
// Сортируем Страны по возрастанию
asort($countries_multiselect);
// Собираем данные для массива Регионов в мультиселекте
$regions_multiselect = \eMarket\Pdo::getColAssoc("SELECT id, country_id, name, region_code  FROM " . TABLE_REGIONS . " WHERE language=?", [lang('#lang_all')[0]]);
// Собираем данные по сопоставлению Страна->Регионы для конкретной зоны
$regions = \eMarket\Pdo::getColAssoc("SELECT country_id, regions_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// Собираем данные для вывода списка стран
$lines_temp = \eMarket\Pdo::getColRow("SELECT country_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);
$lines = array_values(array_unique($lines_temp, SORT_REGULAR)); // Выбираем по 1 экземпляру стран и сбрасываем ключи массива
$lines_on_page = \eMarket\Set::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

// Формирование списка для всплывающих подсказок
$text_arr = [];
for ($y = $start; $y < $finish; $y++) {
    $text = '| ';
    for ($x = 0; $x < count($regions); $x++) {
        if (isset($regions[$x]['country_id']) == TRUE && isset($lines[$y][0]) == TRUE && $regions[$x]['country_id'] == $lines[$y][0]) { // если регион есть
            $text .= \eMarket\Func::filterArrayToKeyAssoc($regions_multiselect, 'country_id', $regions[$x]['country_id'], 'name', 'id')[$regions[$x]['regions_id']] . ' | '; // то, добавляем название региона
        }
    }
    array_push($text_arr, $text);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>