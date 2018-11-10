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

// Получаем zones_id
if ($VALID->inPOST('zone_id')){
    $zones_id = (int) $VALID->inPOST('zone_id');
}

if ($VALID->inGET('zone_id')){
    $zones_id = (int) $VALID->inGET('zone_id');
}

// Если нажали на кнопку Добавить
if ($VALID->inPOST('add') && empty($VALID->inPOST('multiselect')) == FALSE) {

    //Создаем многомерный массив из одномерного, разбитого на части разделителем "-"
    $multiselect = $FUNC->array_explode($VALID->inPOST('multiselect'), '-');
    //Собираем все данные 
    $value_country = $PDO->getCol("SELECT country_id FROM " . TABLE_ZONES_VALUE, []);
    $value_regions = $PDO->getCol("SELECT regions_id FROM " . TABLE_ZONES_VALUE, []);
    $value_zones = $PDO->getCol("SELECT zones_id FROM " . TABLE_ZONES_VALUE, []);
    //Если пусто, то отдаем массив array('false')
    if (empty($value_country) == TRUE) {
        $value_country = array('false');
    }

    if (empty($value_regions) == TRUE) {
        $value_regions = array('false');
    }

    if (empty($value_zones) == TRUE) {
        $value_zones = array('false');
    }

    //$DEBUG->var_dump($multiselect);

    // Проверяем, были ли уже такие значения
    for ($x = 0; $x < count($multiselect); $x++) {
        if (in_array($multiselect[$x][0], $value_country) == FALSE OR
                in_array($multiselect[$x][1], $value_regions) == FALSE OR
                in_array($zones_id, $value_zones) == FALSE) {
            //Если не были, то добавляем
            $PDO->inPrepare("INSERT INTO " . TABLE_ZONES_VALUE . " SET country_id=?, regions_id=?, zones_id=?", [$multiselect[$x][0], $multiselect[$x][1], $zones_id]);
        }
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('id_edit')) {

    for ($xl = 0; $xl < count($lang_all); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_ZONES_VALUE . " SET name=?, note=? WHERE id=? AND language=?", [$VALID->inGET('name_edit' . $lang_all[$xl]), $VALID->inGET('note'), $VALID->inGET('id_edit'), $lang_all[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_ZONES_VALUE . " WHERE country_id=? AND zones_id=?", [$VALID->inPOST('delete'), $zones_id]);
}
//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$name_country = $PDO->getColRow("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
$lines_temp = $PDO->getColRow("SELECT country_id FROM " . TABLE_ZONES_VALUE . " WHERE zones_id=?", [$zones_id]);
$lines = array_values(array_unique($lines_temp, SORT_REGULAR)); // Выбираем по 1 экземпляру стран и сбрасываем ключи массива

$navigate = $NAVIGATION->getLink(count($lines), $lines_of_page = 20);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

// *********  CONNECT PAGE END  ********* //
require_once(ROOT . '/model/end.php');
// ************************************** //

?>