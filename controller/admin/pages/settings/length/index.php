<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
// 
// Если нажали на кнопку Добавить
if ($VALID->inPOST('add')) {

    // Если есть установка по-умолчанию
    if ($VALID->inPOST('default_length')) {
        $default_length = 1;
    } else {
        $default_length = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_LENGTH . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_length != 0) {
        $PDO->inPrepare("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

        //Пересчитываем значения
        $value_length_all = $PDO->getColAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
        $count_value_length_all = count($value_length_all);
        for ($xl = 0; $xl < $count_value_length_all; $xl++) {
            $PDO->inPrepare("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [($value_length_all[$xl]['value_length'] / $VALID->inPOST('value_length')), $value_length_all[$xl]['id'], $value_length_all[$xl]['language']]);
        }
        
        // добавляем запись для всех вкладок
        for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
            $PDO->inPrepare("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$xl]), lang('#lang_all')[$xl], $VALID->inPOST('code' . lang('#lang_all')[$xl]), 1, $default_length]);
        }
    } else {

        // добавляем запись для всех вкладок
        for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
            $PDO->inPrepare("INSERT INTO " . TABLE_LENGTH . " SET id=?, name=?, language=?, code=?, value_length=?, default_length=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$xl]), lang('#lang_all')[$xl], $VALID->inPOST('code' . lang('#lang_all')[$xl]), $VALID->inPOST('value_length'), $default_length]);
        }
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {

    // Если есть установка по-умолчанию
    if ($VALID->inPOST('status_length_edit')) {
        $default_length = 1;
    } else {
        $default_length = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_length != 0) {
        $PDO->inPrepare("UPDATE " . TABLE_LENGTH . " SET default_length=?", [0]);

        //Пересчитываем значения
        $value_length_all = $PDO->getColAssoc("SELECT id, value_length, language FROM " . TABLE_LENGTH, []);
        $count_value_length_all = count($value_length_all);
        for ($xl = 0; $xl < $count_value_length_all; $xl++) {
            $PDO->inPrepare("UPDATE " . TABLE_LENGTH . " SET value_length=? WHERE id=? AND language=?", [($value_length_all[$xl]['value_length'] / $VALID->inPOST('value_length_edit')), $value_length_all[$xl]['id'], $value_length_all[$xl]['language']]);
        }

        for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
            // обновляем запись
            $PDO->inPrepare("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inPOST('code_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), 1, $default_length, $VALID->inPOST('edit'), lang('#lang_all')[$xl]]);
        }
    } else {

        for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
            // обновляем запись
            $PDO->inPrepare("UPDATE " . TABLE_LENGTH . " SET name=?, code=?, value_length=?, default_length=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inPOST('code_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inPOST('value_length_edit'), $default_length, $VALID->inPOST('edit'), lang('#lang_all')[$xl]]);
        }
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_LENGTH . " WHERE id=?", [$VALID->inPOST('delete')]);
}
//print_r($value_length_all[0]['language']);
//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, code, value_length, default_length FROM " . TABLE_LENGTH . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
$lines_on_page = $SET->linesOnPage();
$navigate = $NAVIGATION->getLink(count($lines), $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */
?>