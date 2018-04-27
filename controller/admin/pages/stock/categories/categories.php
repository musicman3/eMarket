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
if ($VALID->inPOST('parent_up')) {
    $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [$VALID->inPOST('parent_up')]);
}

// Устанавливаем родительскую категорию при переходе на уровень ниже
if ($VALID->inPOST('parent_down')) {
    $parent_id = $VALID->inPOST('parent_down');
}

// Если нажали на кнопку Добавить
if ($VALID->inPOST('name')) {

    if ($VALID->inPOST('view_cat')) {
        $view_cat = 1;
    } else {
        $view_cat = 0;
    }

    $sort_category = 0;

    // добавляем запись
    $PDO->insertPrepare("INSERT INTO " . TABLE_CATEGORIES . " SET name=?, sort_category=?, parent_id=?, date_added=?, status=?", [$VALID->inPOST('name'), $sort_category, $parent_id, date("Y-m-d H:i:s"), $view_cat]);
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('name_edit') && $VALID->inPOST('cat_edit')) {

    if ($VALID->inPOST('view_cat')) {
        $view_cat = 1;
    } else {
        $view_cat = 0;
    }

    // обновляем запись
    $PDO->insertPrepare("UPDATE " . TABLE_CATEGORIES . " SET name=?, last_modified=?, status=? WHERE id=?", [$VALID->inPOST('name_edit'), date("Y-m-d H:i:s"), $view_cat, $VALID->inPOST('cat_edit')]);
}

// ГРУППОВЫЕ ДЕЙСТВИЯ: Если нажали на кнопки: Отображать, Скрыть, Удалить, Вырезать, Вставить + выделение
if ($VALID->inPOST('idsx_cut_marker') == 'cut') { // очищаем буфер обмена, если он был заполнен, при нажатии Вырезать
    unset($_SESSION['buffer']);
}

$idsx_real_parent_id = $parent_id; //для отправки в JS

if (($VALID->inPOST('idsx_paste_key') == 'paste')
        or ( $VALID->inPOST('idsx_statusOn_key') == 'statusOn')
        or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {
    $parent_id_real = (int) $VALID->inPOST('idsx_real_parent_id'); // получить значение из JS
}

if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
        or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')
        or ( $VALID->inPOST('idsx_cut_key') == 'cut')
        or ( $VALID->inPOST('idsx_delete_key') == 'delete')) {

    if ($VALID->inPOST('idsx_statusOn_key') == 'statusOn') {
        $idx = $VALID->inPOST('idsx_statusOn_id');
        $status = 1;
    }

    if ($VALID->inPOST('idsx_statusOff_key') == 'statusOff') {
        $idx = $VALID->inPOST('idsx_statusOff_id');
        $status = 0;
    }

    if ($VALID->inPOST('idsx_cut_key') == 'cut') {
        $idx = $VALID->inPOST('idsx_cut_id');
        $parent_id_real = (int) $VALID->inPOST('idsx_real_parent_id'); // получить значение из JS
    }

    if ($VALID->inPOST('idsx_delete_key') == 'delete') {
        $idx = $VALID->inPOST('idsx_delete_id');
    }

    // Устанавливаем родительскую категорию
    $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [$idx]);
    // Устанавливаем родительскую категорию родительской категории
    $parent_id_up = $PDO->selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [$parent_id]);
    // считаем одинаковые parent_id
    $parent_id_num = $PDO->getColRow("SELECT id FROM " . TABLE_CATEGORIES . " WHERE parent_id=?", [$parent_id]);
    // если меньше 2-х значений, то устанавливаем parent_id как родительский родительского
    if (count($parent_id_num) < 2) {
        $parent_id = $parent_id_up;
    }

    //Выбираем данные из БД
    $data_cat = $DB->prepare("SELECT id, parent_id FROM " . TABLE_CATEGORIES);
    $data_cat->execute();

    $category = $idx; // id родителя
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

        //Обновляем статус подкатегорий
        if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
                or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {
            $PDO->insertPrepare("UPDATE " . TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $keys[$x]]);
            if ($parent_id_real > 0) {
                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
            }
        }

        //Удаляем подкатегории
        if ($VALID->inPOST('idsx_delete_key') == 'delete') {
            $PDO->insertPrepare("DELETE FROM " . TABLE_CATEGORIES . " WHERE id=?", [$keys[$x]]);
        }
    }

    //Обновляем статус основной категории
    if (($VALID->inPOST('idsx_statusOn_key') == 'statusOn')
            or ( $VALID->inPOST('idsx_statusOff_key') == 'statusOff')) {
        $PDO->insertPrepare("UPDATE " . TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $idx]);
    }

    //Вырезаем основную родительскую категорию    
    if ($VALID->inPOST('idsx_cut_key') == 'cut') {
        if (!isset($_SESSION['buffer'])) {
            $_SESSION['buffer'] = array();
        }
        array_push($_SESSION['buffer'], $idx);
        if ($parent_id_real > 0) {
            $parent_id = $parent_id_real; // Возвращаемся в свою директорию после обновления
        }
    }

    //Удаляем основную категорию    
    if ($VALID->inPOST('idsx_delete_key') == 'delete') {
        $PDO->insertPrepare("DELETE FROM " . TABLE_CATEGORIES . " WHERE id=?", [$idx]);
    }
}

//Вставляем вырезанные категории    
if ($VALID->inPOST('idsx_paste_key') == 'paste' && isset($_SESSION['buffer']) == TRUE) {
    for ($buf = 0; $buf < count($_SESSION['buffer']); $buf++) {
        $PDO->insertPrepare("UPDATE " . TABLE_CATEGORIES . " SET parent_id=? WHERE id=?", [$parent_id_real, $_SESSION['buffer'][$buf]]);
    }
    unset($_SESSION['buffer']); // очищаем буфер обмена
    if ($parent_id_real > 0) {
        $parent_id = $parent_id_real; // Возвращаемся в свою директорию после вставки
    }
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
// если сортируем категории мышкой
$j = $i; //  переменная для передачи POST в javascript сортировки
if ($VALID->inPOST('token_ajax') == $TOKEN && $VALID->inPOST('ids')) {
    $j2 = $VALID->inPOST('j');
    $sort_ajax = explode(',', $VALID->inPOST('ids'));
    for ($ajax_i = 0; $ajax_i < count($sort_ajax); $ajax_i++) {
        $PDO->insertPrepare("UPDATE " . TABLE_CATEGORIES . " SET sort_category=? WHERE id=?", [$ajax_i + $j2, $sort_ajax[$ajax_i]]);
    }
}

// собираем данные для отображения в Редактировании категорий
$name_category_edit = $PDO->selectPrepare("SELECT name FROM " . TABLE_CATEGORIES . " WHERE id=?", array($lines[$i][0]));
$status_category_edit = $PDO->selectPrepare("SELECT status FROM " . TABLE_CATEGORIES . " WHERE id=?", array($lines[$i][0]));
if ($status_category_edit == 1) {
    $status_category_edit = 'checked';
} else {
    $status_category_edit = '';
}

// ********  CONNECT PAGE END  ******** //
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/connect_page_end.php');
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/html_end.php');
// ************************************ //
//подгрузка JS обработок
require_once('js/js_categories.php');

?>
