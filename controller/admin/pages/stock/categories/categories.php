<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
// 
// Устанавливаем родительскую категорию
$parent_id = $VALID->inGET('parent_id');
if ($parent_id == FALSE) {
    $parent_id = 0;
}

// Устанавливаем родительскую категорию при переходе на уровень выше
if ($VALID->inGET('parent_up')) {
    $parent_id = $PDO->selectPrepare("SELECT parent_id FROM " . TABLE_CATEGORIES . " WHERE id=?", [$VALID->inGET('parent_up')]);
}

// Устанавливаем родительскую категорию при переходе на уровень ниже
if ($VALID->inGET('parent_down')) {
    $parent_id = $VALID->inGET('parent_down');
}

// Если нажали на кнопку Добавить
if ($VALID->inGET($lang_all[0])) {

    if ($VALID->inGET('view_cat')) {
        $view_cat = 1;
    } else {
        $view_cat = 0;
    }

    $sort_category = 0;

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_CATEGORIES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count($lang_all); $xl++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_CATEGORIES . " SET id=?, name=?, sort_category=?, language=?, parent_id=?, date_added=?, status=?", [$id, $VALID->inGET($lang_all[$xl]), $sort_category, $lang_all[$xl], $parent_id, date("Y-m-d H:i:s"), $view_cat]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('cat_edit')) {

    if ($VALID->inGET('view_cat')) {
        $view_cat = 1;
    } else {
        $view_cat = 0;
    }

    for ($xl = 0; $xl < count($lang_all); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_CATEGORIES . " SET name=?, last_modified=?, status=? WHERE id=? AND language=?", [$VALID->inGET('name_edit' . $lang_all[$xl]), date("Y-m-d H:i:s"), $view_cat, $VALID->inGET('cat_edit'), $lang_all[$xl]]);
    }
}

// ГРУППОВЫЕ ДЕЙСТВИЯ: Если нажали на кнопки: Отображать, Скрыть, Удалить, Вырезать, Вставить + выделение
if ($VALID->inGET('idsx_cut_marker') == 'cut') { // очищаем буфер обмена, если он был заполнен, при нажатии Вырезать
    unset($_SESSION['buffer']);
}

$idsx_real_parent_id = $parent_id; //для отправки в JS

if (($VALID->inGET('idsx_paste_key') == 'paste')
        or ( $VALID->inGET('idsx_statusOn_key') == 'statusOn')
        or ( $VALID->inGET('idsx_statusOff_key') == 'statusOff')) {
    $parent_id_real = (int) $VALID->inGET('idsx_real_parent_id'); // получить значение из JS
}

if (($VALID->inGET('idsx_statusOn_key') == 'statusOn')
        or ( $VALID->inGET('idsx_statusOff_key') == 'statusOff')
        or ( $VALID->inGET('idsx_cut_key') == 'cut')
        or ( $VALID->inGET('idsx_delete_key') == 'delete')) {

    if ($VALID->inGET('idsx_statusOn_key') == 'statusOn') {
        $idx = $VALID->inGET('idsx_statusOn_id');
        $status = 1;
    }

    if ($VALID->inGET('idsx_statusOff_key') == 'statusOff') {
        $idx = $VALID->inGET('idsx_statusOff_id');
        $status = 0;
    }

    if ($VALID->inGET('idsx_cut_key') == 'cut') {
        $idx = $VALID->inGET('idsx_cut_id');
        $parent_id_real = (int) $VALID->inGET('idsx_real_parent_id'); // получить значение из JS
    }

    if ($VALID->inGET('idsx_delete_key') == 'delete') {
        $idx = $VALID->inGET('idsx_delete_id');
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
        if (($VALID->inGET('idsx_statusOn_key') == 'statusOn')
                or ( $VALID->inGET('idsx_statusOff_key') == 'statusOff')) {
            $PDO->inPrepare("UPDATE " . TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $keys[$x]]);
            if ($parent_id_real > 0) {
                $parent_id = $parent_id_real; // Возвращаемся в свою директорию после "Вырезать"
            }
        }

        //Удаляем подкатегории
        if ($VALID->inGET('idsx_delete_key') == 'delete') {
            $PDO->inPrepare("DELETE FROM " . TABLE_CATEGORIES . " WHERE id=?", [$keys[$x]]);
        }
    }

    //Обновляем статус основной категории
    if (($VALID->inGET('idsx_statusOn_key') == 'statusOn')
            or ( $VALID->inGET('idsx_statusOff_key') == 'statusOff')) {
        $PDO->inPrepare("UPDATE " . TABLE_CATEGORIES . " SET status=? WHERE id=?", [$status, $idx]);
    }

    //Вырезаем основную родительскую категорию    
    if ($VALID->inGET('idsx_cut_key') == 'cut') {
        if (!isset($_SESSION['buffer'])) {
            $_SESSION['buffer'] = array();
        }
        array_push($_SESSION['buffer'], $idx);
        if ($parent_id_real > 0) {
            $parent_id = $parent_id_real; // Возвращаемся в свою директорию после обновления
        }
    }

    //Удаляем основную категорию    
    if ($VALID->inGET('idsx_delete_key') == 'delete') {
        $PDO->inPrepare("DELETE FROM " . TABLE_CATEGORIES . " WHERE id=?", [$idx]);
    }
}

//Вставляем вырезанные категории    
if ($VALID->inGET('idsx_paste_key') == 'paste' && isset($_SESSION['buffer']) == TRUE) {
    for ($buf = 0; $buf < count($_SESSION['buffer']); $buf++) {
        $PDO->inPrepare("UPDATE " . TABLE_CATEGORIES . " SET parent_id=? WHERE id=?", [$parent_id_real, $_SESSION['buffer'][$buf]]);
    }
    unset($_SESSION['buffer']); // очищаем буфер обмена
    if ($parent_id_real > 0) {
        $parent_id = $parent_id_real; // Возвращаемся в свою директорию после вставки
    }
}

// КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// задаем количество строк на странице вывода категорий
if (isset($_SESSION['select_category']) == FALSE) {
    $_SESSION['select_category'] = $lines_on_page;
} elseif (isset($_SESSION['select_category']) == TRUE && $VALID->inGET('select_row')) {
    $_SESSION['select_category'] = $VALID->inGET('select_row');
    $lines_on_page = $_SESSION['select_category'];
} else {
    $lines_on_page = $_SESSION['select_category'];
}

$start = 0; // устанавливаем страницу в ноль при заходе
$finish = $lines_on_page;

// Если parrent_id является массивом, то
if (is_array($parent_id) == TRUE) {
    $parent_id = 0;
}

// Устанавливаем родительскую категорию при навигации назад-вперед
if ($VALID->inGET('parent_id_temp')) {
    $parent_id = $VALID->inGET('parent_id_temp');
}
// получаем отсортированное по sort_category содержимое в виде массива для отображения на странице и сортируем в обратном порядке
$lines = array_reverse($PDO->getColRow("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent_id=? AND language=? ORDER BY sort_category DESC", [$parent_id, $lang_all[0]]));
$count_lines = count($lines);  //считаем количество строк

if ($count_lines <= $lines_on_page) {
    $finish = $count_lines;
}
// Если нажали на кнопку вперед
if ($VALID->inGET('finish')) {
    $finish = $VALID->inGET('finish') + $lines_on_page; // пересчитываем количество строк на странице
    if ($VALID->inGET('start') == FALSE) {
        $vali = 0;
    } else {
        $vali = $VALID->inGET('start');
    }
    $start = $vali + $lines_on_page; // задаем значение счетчика
    if ($start >= $count_lines) {
        $start = $vali;
    }
    if ($finish >= $count_lines) {
        $finish = $count_lines;
    }
}
// Если нажали на кнопку назад
if ($count_lines >= $lines_on_page) {
    if ($VALID->inGET('finish2')) {
        $finish = $VALID->inGET('start2'); // пересчитываем количество строк на странице
        $start = $VALID->inGET('start2') - $lines_on_page; // задаем значение счетчика
        if ($start < 0) {
            $start = 0;
        }
        if ($finish < $lines_on_page) {
            $finish = $lines_on_page;
        }
    }
}
// КОНЕЦ-> КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// если сортируем категории мышкой
$j = $start; //  переменная для передачи GET в javascript сортировки
if ($VALID->inGET('token_ajax') == $TOKEN && $VALID->inGET('ids')) {
    $j2 = $VALID->inGET('j');
    $sort_ajax = explode(',', $VALID->inGET('ids'));
    for ($ajax_i = 0; $ajax_i < count($sort_ajax); $ajax_i++) {
        $PDO->inPrepare("UPDATE " . TABLE_CATEGORIES . " SET sort_category=? WHERE id=?", [$ajax_i + $j2, $sort_ajax[$ajax_i]]);
    }
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */

?>
