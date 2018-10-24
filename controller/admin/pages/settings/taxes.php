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
// Если нажали на кнопку Добавить
if ($VALID->inGET('rate')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count($lang_all); $xl++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TAXES . " SET id=?, name=?, language=?, rate=?", [$id, $VALID->inGET($lang_all[$xl]), $lang_all[$xl], $VALID->inGET('rate')]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('id_edit')) {

    for ($xl = 0; $xl < count($lang_all); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_TAXES . " SET name=?, rate=? WHERE id=? AND language=?", [$VALID->inGET('name_edit' . $lang_all[$xl]), $VALID->inGET('rate_edit'), $VALID->inGET('id_edit'), $lang_all[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inGET('tax_delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_TAXES . " WHERE id=?", [$VALID->inGET('tax_delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// Получаем массив таблицы
$lines = $PDO->getColRow("SELECT id, name, rate FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
// Cчитаем количество записей
$counter = $PDO->getRowCount("SELECT id FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
// Подключаем файл навигации
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/includes/navigation.php');

// *********  CONNECT PAGE END  ********* //
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/connect_page_end.php');
// ************************************** //
?>