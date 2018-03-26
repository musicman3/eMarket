<?php
// ****** Copyright © 2018 eMarket *****//
//   GNU GENERAL PUBLIC LICENSE v.3.0   //
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/connect_page_start.php');
// ************************************** //
// 
// Устанавливаем родительскую категорию
$parent_id = $VALID->inPOST('parent_id');
if ($parent_id == FALSE) {
    $parent_id = 0;
}

// Устанавливаем родительскую категорию при переходе на уровень выше
if ($VALID->inPOST('parent_up') == TRUE) {
    $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", array($VALID->inPOST('parent_up')));
}

// Устанавливаем родительскую категорию при переходе на уровень ниже
if ($VALID->inPOST('parent_down') == TRUE) {
    $parent_id = $VALID->inPOST('parent_down');
}

// Если нажали на кнопку Добавить
if ($VALID->inPOST('name') == TRUE) {

    if ($VALID->inPOST('view_cat') == 'on') {
        $view_cat = 1;
    } else {
        $view_cat = 0;
    }

    $sort_category = 0;

    // добавляем запись
    $PDO->insertPrepare("INSERT INTO " . TABLE_CATEGORIES . " SET name=?, sort_category=?, parent_id=?, date_added=?, status=?", array($VALID->inPOST('name'), $sort_category, $parent_id, date("Y-m-d H:i:s"), $view_cat));
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('name_edit') == TRUE && $VALID->inPOST('cat_edit') == TRUE) {

    if ($VALID->inPOST('view_cat') == 'on') {
        $view_cat = 1;
    } else {
        $view_cat = 0;
    }

    // обновляем запись
    $PDO->insertPrepare("UPDATE " . TABLE_CATEGORIES . " SET name=?, last_modified=?, status=? WHERE id=?", array($VALID->inPOST('name_edit'), date("Y-m-d H:i:s"), $view_cat, $VALID->inPOST('cat_edit')));
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('cat_delete') == TRUE) {

    // Устанавливаем родительскую категорию
    $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", array($VALID->inPOST('cat_delete')));
    // Устанавливаем родительскую категорию родительской категории
    $parent_id_up = $PDO->selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", array($parent_id));
    // считаем одинаковые parent_id
    $parent_id_num = $PDO->getColRow("SELECT id FROM " . TABLE_CATEGORIES . " WHERE parent_id=?", array($parent_id));
    // если меньше 2-х значений, то устанавливаем parent_id как родительский родительского
    if (count($parent_id_num) < 2) {
        $parent_id = $parent_id_up;
    }

    //Выбираем данные из БД
    $data_cat = $DB->prepare("SELECT id, parent_id FROM " . TABLE_CATEGORIES);
    $data_cat->execute();

    $category = $VALID->inPOST('cat_delete'); // id родителя
    $categories = array();
    $keys = array(); // массив ключей
    $keys[] = $category; // добавляем первый ключ в массив
    // В цикле формируем ассоциативный массив разделов
    while ($category = $data_cat->fetch(PDO::FETCH_ASSOC)) {
        // Проверяем наличие id категории в массиве ключей
        if (in_array($category['parent_id'], $keys)) {
            $categories[$category['parent_id']][] = $category['id'];
            $keys[] = $category['id']; // расширяем массив
        }
    }

    for ($x = 0; $x < count($keys); $x++) {
        //Удаляем подкатегории
        $PDO->insertPrepare("DELETE FROM " . TABLE_CATEGORIES . " WHERE id=?", array($keys[$x]));
    }
    //удаляем основную категорию
    $PDO->insertPrepare("DELETE FROM " . TABLE_CATEGORIES . " WHERE id=?", array($VALID->inPOST('cat_delete')));
}

// КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = array();
$lines_page = 20; // задаем количество строк на странице вывода
$i = 0; // устанавливаем страницу в ноль при заходе
$lines_p = $lines_page;

// Если parrent_id является массивом, то
if (is_array($parent_id) == TRUE) {
    $parent_id = 0;
}

// Устанавливаем родительскую категорию при навигации назад-вперед
if ($VALID->inPOST('parent_id_temp') == TRUE) {
    $parent_id = $VALID->inPOST('parent_id_temp');
}
// получаем отсортированное по sort_category содержимое в виде массива
$lines = $PDO->getColRow("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent_id=? ORDER BY sort_category DESC", array($parent_id));
$lines = array_reverse($lines); // сортируем в обратном порядке
$counter = count($lines);  //считаем количество строк

if ($counter <= $lines_page) {
    $lines_p = $counter;
}
// Если нажали на кнопку вперед
if ($VALID->inPOST('lines_p') == TRUE) {
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
// если сортируем категории мышкой
$j = $i; //  переменная для передачи POST в javascript сортировки
if ($VALID->inPOST('ids') && $VALID->inPOST('token_ajax') == $token) {
    $j2 = $VALID->inPOST('j');
    $sort_ajax = explode(',', $VALID->inPOST('ids'));
    for ($ajax_i = 0; $ajax_i < count($sort_ajax); $ajax_i++) {
        $PDO->insertPrepare("UPDATE " . TABLE_CATEGORIES . " SET sort_category=? WHERE id=?", array($ajax_i + $j2, $sort_ajax[$ajax_i]));
    }
}

// ********  CONNECT PAGE END  ******** //
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/connect_page_end.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/html_end.php');
// ************************************ //

?>
