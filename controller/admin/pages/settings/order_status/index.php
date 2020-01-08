<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// 
// Если нажали на кнопку Добавить
if (\eMarket\Valid::inPOST('add')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_order_status')) {
        $default_order_status = 1;
    } else {
        $default_order_status = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = \eMarket\Pdo::selectPrepare("SELECT id FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_order_status != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_ORDER_STATUS . " SET default_order_status=?", [0]);
    }
    
    // Получаем последний sort и увеличиваем его на 1
    $id_max_sort = \eMarket\Pdo::selectPrepare("SELECT sort FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
    $id_sort = intval($id_max_sort) + 1;

    // добавляем запись для всех вкладок
    for ($x = 0; $x < $LANG_COUNT; $x++) {
        \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_ORDER_STATUS . " SET id=?, name=?, language=?, default_order_status=?, sort=?", [$id, \eMarket\Valid::inPOST('name_order_status_' . $x), lang('#lang_all')[$x], $default_order_status, $id_sort]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Редактировать
if (\eMarket\Valid::inPOST('edit')) {

    // Если есть установка по-умолчанию
    if (\eMarket\Valid::inPOST('default_order_status_edit')) {
        $default_order_status = 1;
    } else {
        $default_order_status = 0;
    }
    // Оставляем один экземпляр значения по-умолчанию
    if ($default_order_status != 0) {
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_ORDER_STATUS . " SET default_order_status=?", [0]);
    }

    for ($x = 0; $x < $LANG_COUNT; $x++) {
        // обновляем запись
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_ORDER_STATUS . " SET name=?, default_order_status=? WHERE id=? AND language=?", [\eMarket\Valid::inPOST('name_order_status_edit_' . $x), $default_order_status, \eMarket\Valid::inPOST('edit'), lang('#lang_all')[$x]]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

// Если нажали на кнопку Удалить
if (\eMarket\Valid::inPOST('delete')) {

    // Удаляем
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_ORDER_STATUS . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

        // если сортируем категории мышкой
        if (\eMarket\Valid::inPOST('token_ajax') == $TOKEN && \eMarket\Valid::inPOST('ids')) {
            $sort_array_id_ajax = explode(',', \eMarket\Valid::inPOST('ids')); // Массив со списком id под сортировку
            // Если в массиве пустое значение, то собираем новый массив без этого значения со сбросом ключей
            $sort_array_id = \eMarket\Func::deleteEmptyInArray($sort_array_id_ajax);

            $sort_array_category = []; // Массив со списком sort_category под сортировку

            $count_sort_array_id = count($sort_array_id); // Получаем количество значений в массиве

            for ($i = 0; $i < $count_sort_array_id; $i++) {
                $sort_category = \eMarket\Pdo::selectPrepare("SELECT sort FROM " . TABLE_ORDER_STATUS . " WHERE id=? AND language=? ORDER BY id ASC", [$sort_array_id[$i], lang('#lang_all')[0]]);
                array_push($sort_array_category, $sort_category); // Добавляем данные в массив sort_category
                arsort($sort_array_category); // Сортируем массив со списком sort_category
            }
            // Создаем финальный массив из двух массивов
            $sort_array_final = array_combine($sort_array_id, $sort_array_category);

            for ($i = 0; $i < $count_sort_array_id; $i++) {

                \eMarket\Pdo::inPrepare("UPDATE " . TABLE_ORDER_STATUS . " SET sort=? WHERE id=?", [(int) $sort_array_final[$sort_array_id[$i]], (int) $sort_array_id[$i]]);
            }
        }

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = \eMarket\Pdo::getColRow("SELECT id, name, default_order_status, sort FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
$lines_on_page = \eMarket\Set::linesOnPage();
$navigate = \eMarket\Navigation::getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>