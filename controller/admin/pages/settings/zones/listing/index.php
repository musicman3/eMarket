<?php

// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
// ************************************** //
// 
// Собираем данные для массива Стран
$countries_multiselect_temp = $PDO->getColRow("SELECT name, id  FROM " . TABLE_COUNTRIES . " WHERE language=?", [$lang_all[0]]);
// Собираем одномерный массив id=>Страна
$countries_multiselect = array_column($countries_multiselect_temp, 0, 1);
// Сортируем Страны по возрастанию
asort($countries_multiselect);

// Собираем данные для массива Регионов
$regions_multiselect = $PDO->getColRow("SELECT id, country_id, name, region_code  FROM " . TABLE_REGIONS . " WHERE language=?", [$lang_all[0]]);


// Если нажали на кнопку Добавить
if ($VALID->inPOST('add')) {
    
    //Создаем многомерный массив из одномерного, разбитого на части разделителем "-"
$multiselect = $FUNC->array_explode($VALID->inPOST('multiselect'), '-');


$DEBUG->var_dump($multiselect);

    // добавляем запись для всех выборок
    for ($x = 0; $x < count($multiselect); $x++) {
        if ($multiselect[$x][0] != $m OR isset($m) == FALSE ) {
        $PDO->inPrepare("INSERT INTO " . TABLE_COUNTRIES_ZONES . " SET country_id=?, zones_id=?", [$multiselect[$x][0], '1']);
    }
        $m = $multiselect[$x][0];
    
    }
    
        // добавляем запись для всех выборок
    for ($x = 0; $x < count($multiselect); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_REGIONS_ZONES . " SET country_id=?, regions_id=?", [$multiselect[$x][0], $multiselect[$x][1]]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('id_edit')) {

    for ($xl = 0; $xl < count($lang_all); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_ZONES . " SET name=?, note=? WHERE id=? AND language=?", [$VALID->inGET('name_edit' . $lang_all[$xl]), $VALID->inGET('note'), $VALID->inGET('id_edit'), $lang_all[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_ZONES . " WHERE id=?", [$VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id FROM " . TABLE_COUNTRIES_ZONES . " WHERE zones_id=?", ['0']);
$navigate = $NAVIGATION->getLink(count($lines), $lines_of_page = 20);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

// *********  CONNECT PAGE END  ********* //
require_once(ROOT . '/model/end.php');
// ************************************** //
?>