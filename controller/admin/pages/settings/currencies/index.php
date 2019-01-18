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
    if ($VALID->inPOST('default_value')) {
        $default_value = 1;
    } else {
        $default_value = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_CURRENCIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_value != 0) {
        $PDO->inPrepare("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

        //Пересчитываем значения
        $value_all = $PDO->getColAssoc("SELECT id, value, language FROM " . TABLE_CURRENCIES, []);
        $count_value_all = count($value_all);
        for ($x = 0; $x < $count_value_all; $x++) {
            $PDO->inPrepare("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [($value_all[$x]['value'] / $VALID->inPOST('value')), $value_all[$x]['id'], $value_all[$x]['language']]);
        }
        
        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            $PDO->inPrepare("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, value=?, default_value=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$x]), lang('#lang_all')[$x], $VALID->inPOST('code' . lang('#lang_all')[$x]), 1, $default_value]);
        }
    } else {

        // добавляем запись для всех вкладок
        for ($x = 0; $x < $LANG_COUNT; $x++) {
            $PDO->inPrepare("INSERT INTO " . TABLE_CURRENCIES . " SET id=?, name=?, language=?, code=?, value=?, default_value=?", [$id, $VALID->inPOST($SET->titleDir() . '_' . lang('#lang_all')[$x]), lang('#lang_all')[$x], $VALID->inPOST('code' . lang('#lang_all')[$x]), $VALID->inPOST('value'), $default_value]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Редактировать
if ($VALID->inPOST('edit')) {

    // Если есть установка по-умолчанию
    if ($VALID->inPOST('status_value_edit')) {
        $default_value = 1;
    } else {
        $default_value = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_value != 0) {
        $PDO->inPrepare("UPDATE " . TABLE_CURRENCIES . " SET default_value=?", [0]);

        //Пересчитываем значения
        $value_all = $PDO->getColAssoc("SELECT id, value, language FROM " . TABLE_CURRENCIES, []);
        $count_value_all = count($value_all);
        for ($x = 0; $x < $count_value_all; $x++) {
            $PDO->inPrepare("UPDATE " . TABLE_CURRENCIES . " SET value=? WHERE id=? AND language=?", [($value_all[$x]['value'] / $VALID->inPOST('value_edit')), $value_all[$x]['id'], $value_all[$x]['language']]);
        }

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            $PDO->inPrepare("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, value=?, default_value=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$x]), $VALID->inPOST('code_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$x]), 1, $default_value, $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
        }
    } else {

        for ($x = 0; $x < $LANG_COUNT; $x++) {
            // обновляем запись
            $PDO->inPrepare("UPDATE " . TABLE_CURRENCIES . " SET name=?, code=?, value=?, default_value=? WHERE id=? AND language=?", [$VALID->inPOST('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$x]), $VALID->inPOST('code_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$x]), $VALID->inPOST('value_edit'), $default_value, $VALID->inPOST('edit'), lang('#lang_all')[$x]]);
        }
    }
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_CURRENCIES . " WHERE id=?", [$VALID->inPOST('delete')]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, code, value, default_value FROM " . TABLE_CURRENCIES . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
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