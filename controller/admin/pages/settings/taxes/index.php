<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
// ************************************** //
// 
// Если нажали на кнопку Добавить
if ($VALID->inGET('add')) {

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
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_TAXES . " WHERE id=?", [$VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, rate FROM " . TABLE_TAXES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
$navigate = $NAVIGATION->getLink(count($lines), $lines_of_page = 20);
$start = $navigate[0];
$finish = $navigate[1];

// *********  CONNECT PAGE END  ********* //
require_once(ROOT . '/model/end.php');
// ************************************** //

?>