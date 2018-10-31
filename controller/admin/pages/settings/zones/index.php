<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ********  CONNECT PAGE START  ******** //
require_once(getenv('DOCUMENT_ROOT') . '/model/connect_page_start.php');
// ************************************** //
// 
//Сохраняем сессию с URL текущей страницы
$_SESSION['zone_page'] = $VALID->inSERVER('REQUEST_URI');

// Если нажали на кнопку Добавить
if ($VALID->inGET($lang_all[0])) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_ZONES . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count($lang_all); $xl++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_ZONES . " SET id=?, name=?, note=?, language=?", [$id, $VALID->inGET($lang_all[$xl]), $VALID->inGET('note'), $lang_all[$xl]]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('id_edit')) {

    for ($xl = 0; $xl < count($lang_all); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_ZONES . " SET name=?, note=? WHERE id=? AND language=?", [$VALID->inGET('name_edit' . $lang_all[$xl]), $VALID->inGET('note'), $VALID->inGET('id_edit'), $lang_all[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_ZONES . " WHERE id=?", [$VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, name, note FROM " . TABLE_ZONES . " WHERE language=? ORDER BY name", [$lang_all[0]]);
$navigate = $NAVIGATOR->getNavi(count($lines), $l_page = 20);
$l_finish = $navigate[0];
$l_start = $navigate[1];

// *********  CONNECT PAGE END  ********* //
require_once(ROOT . '/model/connect_page_end.php');
// ************************************** //

?>