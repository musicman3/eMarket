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
if ($VALID->inGET('add')) {

    // Если есть установка по-умолчанию
    if ($VALID->inGET('default_weight')) {
        $default_weight = 1;
    } else {
        $default_weight = 0;
    }

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_WEIGHT . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
    $id = intval($id_max) + 1;

    // Оставляем один экземпляр значения по-умолчанию
    if ($id > 1 && $default_weight != 0) {
        $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);

        //Пересчитываем значения
        $value_weight_all = $PDO->getColAssoc("SELECT id, value_weight, language FROM " . TABLE_WEIGHT, []);
        $count_value_weight_all = count($value_weight_all);
        for ($xl = 0; $xl < $count_value_weight_all; $xl++) {
            $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET value_weight=? WHERE id=? AND language=?", [($value_weight_all[$xl]['value_weight'] / $VALID->inGET('value_weight')), $value_weight_all[$xl]['id'], $value_weight_all[$xl]['language']]);
        }
        
        // добавляем запись для всех вкладок
        for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
            $PDO->inPrepare("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [$id, $VALID->inGET($SET->titleDir() . '_' . lang('#lang_all')[$xl]), lang('#lang_all')[$xl], $VALID->inGET('code' . lang('#lang_all')[$xl]), 1, $default_weight]);
        }
    } else {

        // добавляем запись для всех вкладок
        for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
            $PDO->inPrepare("INSERT INTO " . TABLE_WEIGHT . " SET id=?, name=?, language=?, code=?, value_weight=?, default_weight=?", [$id, $VALID->inGET($SET->titleDir() . '_' . lang('#lang_all')[$xl]), lang('#lang_all')[$xl], $VALID->inGET('code' . lang('#lang_all')[$xl]), $VALID->inGET('value_weight'), $default_weight]);
        }
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('edit')) {

    // Если есть установка по-умолчанию
    if ($VALID->inGET('status_weight_edit')) {
        $default_weight = 1;
    } else {
        $default_weight = 0;
    }

    // Оставляем один экземпляр значения по-умолчанию
    if ($default_weight != 0) {
        $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET default_weight=?", [0]);

        //Пересчитываем значения
        $value_weight_all = $PDO->getColAssoc("SELECT id, value_weight, language FROM " . TABLE_WEIGHT, []);
        $count_value_weight_all = count($value_weight_all);
        for ($xl = 0; $xl < $count_value_weight_all; $xl++) {
            $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET value_weight=? WHERE id=? AND language=?", [($value_weight_all[$xl]['value_weight'] / $VALID->inGET('value_weight_edit')), $value_weight_all[$xl]['id'], $value_weight_all[$xl]['language']]);
        }

        for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
            // обновляем запись
            $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [$VALID->inGET('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inGET('code_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), 1, $default_weight, $VALID->inGET('edit'), lang('#lang_all')[$xl]]);
        }
    } else {

        for ($xl = 0; $xl < count(lang('#lang_all')); $xl++) {
            // обновляем запись
            $PDO->inPrepare("UPDATE " . TABLE_WEIGHT . " SET name=?, code=?, value_weight=?, default_weight=? WHERE id=? AND language=?", [$VALID->inGET('name_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inGET('code_edit_' . $SET->titleDir() . '_' . lang('#lang_all')[$xl]), $VALID->inGET('value_weight_edit'), $default_weight, $VALID->inGET('edit'), lang('#lang_all')[$xl]]);
        }
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_WEIGHT . " WHERE id=?", [$VALID->inPOST('delete')]);
}
//print_r($value_weight_all[0]['language']);
//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, code, value_weight, default_weight FROM " . TABLE_WEIGHT . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
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