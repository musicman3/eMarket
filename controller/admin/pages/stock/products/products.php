<?php
// ****** Copyright © 2018 eMarket *****//
//   GNU GENERAL PUBLIC LICENSE v.3.0   //
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once(getenv('DOCUMENT_ROOT') . '/model/connect_start.php');
// ************************************** //
// Устанавливаем родительскую категорию
$parent_id = $VALID->inPOST('parent_id');
if ($parent_id == FALSE) {
    $parent_id = 0;
}

// КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = array();

// задаем количество строк на странице вывода категорий
if (isset($_SESSION['select_category']) == FALSE) {
    $lines_of_page = 20;
    $_SESSION['select_category'] = $lines_of_page;
} elseif (isset($_SESSION['select_category']) == TRUE && $VALID->inPOST('select_row')) {
    $_SESSION['select_category'] = $VALID->inPOST('select_row');
    $lines_of_page = $_SESSION['select_category'];
} else {
    $lines_of_page = $_SESSION['select_category'];
}

$start = 0; // устанавливаем страницу в ноль при заходе
$finish = $lines_of_page;

// Если parrent_id является массивом, то
if (is_array($parent_id) == TRUE) {
    $parent_id = 0;
}

// Устанавливаем родительскую категорию при навигации назад-вперед
if ($VALID->inPOST('parent_id_temp')) {
    $parent_id = $VALID->inPOST('parent_id_temp');
}
// получаем отсортированное по sort_category содержимое в виде массива
$lines = $PDO->getColRow("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent_id=? ORDER BY sort_category DESC", [$parent_id]);
$lines = array_reverse($lines); // сортируем в обратном порядке
$count_lines = count($lines);  //считаем количество строк

if ($count_lines <= $lines_of_page) {
    $finish = $count_lines;
}
// Если нажали на кнопку вперед
if ($VALID->inPOST('finish')) {
    $finish = $VALID->inPOST('finish') + $lines_of_page; // пересчитываем количество строк на странице
    if ($VALID->inPOST('start') == FALSE) {
        $vali = 0;
    } else {
        $vali = $VALID->inPOST('start');
    }
    $start = $vali + $lines_of_page; // задаем значение счетчика
    if ($start >= $count_lines) {
        $start = $vali;
    }
    if ($finish >= $count_lines) {
        $finish = $count_lines;
    }
}
// Если нажали на кнопку назад
if ($count_lines >= $lines_of_page) {
    if ($VALID->inPOST('finish2')) {
        $finish = $VALID->inPOST('start2'); // пересчитываем количество строк на странице
        $start = $VALID->inPOST('start2') - $lines_of_page; // задаем значение счетчика
        if ($start < 0) {
            $start = 0;
        }
        if ($finish < $lines_of_page) {
            $finish = $lines_of_page;
        }
    }
}
// КОНЕЦ-> КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// 
// Формат даты после Datepicker
if ($VALID->inPOST('date_available')) {
    $date_available = date('Y-m-d', strtotime($VALID->inPOST('date_available')));
} else {

    $date_available = NULL;
}

// Формируем массив Налог для выпадающего списка
$taxes_all = $PDO->getCol("SELECT name FROM " . TABLE_TAXES . " WHERE language=?", [$lang_all[0]]);

// Формируем массив Единица измерения для выпадающего списка
$units_all = $PDO->getCol("SELECT unit FROM " . TABLE_UNITS . " WHERE language=?", [$lang_all[0]]);

// Если нажали на кнопку Добавить
if ($VALID->inPOST('name')) {

    if ($VALID->inPOST('view_product')) {
        $view_product = 1;
    } else {
        $view_product = 0;
    }

    $sort_product = 0;
    $prod_id_temp = 0;
    $prod_id = $prod_id_temp++;

    // добавляем запись
    $PDO->inPrepare("INSERT INTO " . TABLE_PRODUCTS .
            " SET id=?, name=?, parent_id=?, date_added=?, date_available=?, model=?, price=?, quantity=?, keyword=?, tags=?, description=?", [$prod_id, $VALID->inPOST('name'), $parent_id, date("Y-m-d H:i:s"), $date_available, $VALID->inPOST('model'), $VALID->inPOST('price'),
        $VALID->inPOST('quantity'), $VALID->inPOST('keyword'), $VALID->inPOST('tags'), $VALID->inPOST('description')]);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

// ********  CONNECT PAGE END  ******** //
require_once(ROOT . '/model/connect_end.php');
// ************************************ //
?>