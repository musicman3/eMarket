<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// 
// Получаем zones_id
if (\eMarket\Core\Valid::inPOST('zone_id')) {
    $zones_id = (int) \eMarket\Core\Valid::inPOST('zone_id');
}

if (\eMarket\Core\Valid::inGET('zone_id')) {
    $zones_id = (int) \eMarket\Core\Valid::inGET('zone_id');
}

// Если нажали на кнопку Добавить
if (\eMarket\Core\Valid::inPOST('add')) {

    // Очищаем страны и регионы из этой зоны
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);

    if (empty(\eMarket\Core\Valid::inPOST('multiselect')) == FALSE) {
        // Создаем многомерный массив из одномерного, разбитого на части разделителем "-"
        $multiselect = \eMarket\Other\Func::arrayExplode(\eMarket\Core\Valid::inPOST('multiselect'), '-');
        // Добавляем выбранные в мультиселекте данные
        for ($x = 0; $x < count($multiselect); $x++) {
            \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_ZONES_VALUE . " SET country_id=?, regions_id=?, zones_id=?", [$multiselect[$x][0], $multiselect[$x][1], $zones_id]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Собираем данные для массива Стран в мультиселекте
$countries_multiselect_temp = \eMarket\Core\Pdo::getColRow("SELECT name, id  FROM " . TABLE_COUNTRIES . " WHERE language=?", [lang('#lang_all')[0]]);
// Собираем одномерный массив id=>Страна
$countries_multiselect = array_column($countries_multiselect_temp, 0, 1);
// Сортируем Страны по возрастанию
asort($countries_multiselect);
// Собираем данные для массива Регионов в мультиселекте
$regions_multiselect = \eMarket\Core\Pdo::getColRow("SELECT id, country_id, name, region_code  FROM " . TABLE_REGIONS . " WHERE language=?", [lang('#lang_all')[0]]);
// Собираем название стран и регионов для вывода в View
$name_country = \eMarket\Core\Pdo::getColRow("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$name_regions = \eMarket\Core\Pdo::getColRow("SELECT country_id, name FROM " . TABLE_REGIONS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
// Собираем данные по сопоставлению Страна->Регионы для конкретной зоны
$regions = \eMarket\Core\Pdo::getColRow("SELECT country_id, regions_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// Собираем данные для вывода списка стран
$lines_temp = \eMarket\Core\Pdo::getColRow("SELECT country_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);
$lines = array_values(array_unique($lines_temp, SORT_REGULAR)); // Выбираем по 1 экземпляру стран и сбрасываем ключи массива
$lines_on_page = \eMarket\Core\Set::linesOnPage();
$navigate = \eMarket\Core\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

// Формирование списка для всплывающих подсказок
$text_arr = [];
for ($y = $start; $y < $finish; $y++) {
    $text = '| ';
    for ($x = 0; $x < count($regions); $x++) {
        if (isset($regions[$x][0]) == TRUE && isset($lines[$y][0]) == TRUE && $regions[$x][0] == $lines[$y][0]) { // если регион есть
            $text .= \eMarket\Other\Func::filterArrayToKey($name_regions, 0, $regions[$x][0], 1)[$regions[$x][1]] . ' | '; // то, добавляем название региона
        }
    }
    array_push($text_arr, $text);
}
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>