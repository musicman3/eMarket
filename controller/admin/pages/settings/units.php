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
if ($VALID->inGET('unit'.$lang_all[0])) {

    // Получаем последний id и увеличиваем его на 1
    $id_tax_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_UNITS . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
    $id = intval($id_tax_max) + 1;

    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count($lang_all); $xl++) {
        $PDO->insertPrepare("INSERT INTO " . TABLE_UNITS . " SET id=?, name=?, language=?, unit=?", [$id, $VALID->inGET($lang_all[$xl]), $lang_all[$xl], $VALID->inGET('unit'.$lang_all[$xl])]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('unit_edit')) {

    for ($xl = 0; $xl < count($lang_all); $xl++) {
        // обновляем запись
        $PDO->insertPrepare("UPDATE " . TABLE_UNITS . " SET name=?, rate=? WHERE id=? AND language=?", [$VALID->inGET('name_edit' . $lang_all[$xl]), $VALID->inGET('rate_edit'), $VALID->inGET('tax_edit'), $lang_all[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inGET('unit_delete')) {

    // Удаляем
    $PDO->insertPrepare("DELETE FROM " . TABLE_UNITS . " WHERE id=?", [$VALID->inGET('unit_delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
// Получаем массив таблицы
$lines = $PDO->getColRow("SELECT id, name, unit FROM " . TABLE_UNITS . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
// Cчитаем количество записей
$counter = $PDO->getRowCount("SELECT id FROM " . TABLE_UNITS . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
// Подключаем файл навигации
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/includes/navigation.php');
//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
//
// *********  CONNECT PAGE END  ********* //
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/connect_page_end.php');
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/html_end.php');
// ************************************** //
?>
</body>
</html>