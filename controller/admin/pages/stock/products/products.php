<?php

// ****** Copyright © 2018 eMarket *****//
//   GNU GENERAL PUBLIC LICENSE v.3.0   //
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/connect_page_start.php');
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
    $lines_page = 20;
    $_SESSION['select_category'] = $lines_page;
} elseif (isset($_SESSION['select_category']) == TRUE && $VALID->inPOST('select_row')) {
    $_SESSION['select_category'] = $VALID->inPOST('select_row');
    $lines_page = $_SESSION['select_category'];
} else {
    $lines_page = $_SESSION['select_category'];
}

$i = 0; // устанавливаем страницу в ноль при заходе
$lines_p = $lines_page;

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
$counter = count($lines);  //считаем количество строк

if ($counter <= $lines_page) {
    $lines_p = $counter;
}
// Если нажали на кнопку вперед
if ($VALID->inPOST('lines_p')) {
    $lines_p = $VALID->inPOST('lines_p') + $lines_page; // пересчитываем количество строк на странице
    if ($VALID->inPOST('i') == FALSE) {
        $vali = 0;
    } else {
        $vali = $VALID->inPOST('i');
    }
    $i = $vali + $lines_page; // задаем значение счетчика
    if ($i >= $counter) {
        $i = $vali;
    }
    if ($lines_p >= $counter) {
        $lines_p = $counter;
    }
}
// Если нажали на кнопку назад
if ($counter >= $lines_page) {
    if ($VALID->inPOST('lines_p2')) {
        $lines_p = $VALID->inPOST('i2'); // пересчитываем количество строк на странице
        $i = $VALID->inPOST('i2') - $lines_page; // задаем значение счетчика
        if ($i < 0) {
            $i = 0;
        }
        if ($lines_p < $lines_page) {
            $lines_p = $lines_page;
        }
    }
}
// КОНЕЦ-> КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ

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
    $PDO->insertPrepare("INSERT INTO " . TABLE_PRODUCTS . 
            " SET id=?, name=?, parent_id=?, date_added=?, model=?, price=?, quantity=?, keyword=?, tags=?, description=?",
            [$prod_id, $VALID->inPOST('name'), $parent_id, date("Y-m-d H:i:s"), $VALID->inPOST('model'), $VALID->inPOST('price'), 
                $VALID->inPOST('quantity'), $VALID->inPOST('keyword'), $VALID->inPOST('tags'), $VALID->inPOST('description')]);
}


// ********  CONNECT PAGE END  ******** //
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/connect_page_end.php');
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/html_end.php');
// ************************************ //
//подгрузка JS обработок
require_once('js/js_products.php');
?>
</body>
</html>