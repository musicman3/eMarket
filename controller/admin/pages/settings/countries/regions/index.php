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
if ($VALID->inGET('region_code')) {

    // Получаем последний id и увеличиваем его на 1
    $id_max = $PDO->selectPrepare("SELECT id FROM " . TABLE_REGIONS . " WHERE language=? ORDER BY id DESC", [$lang_all[0]]);
    $id = intval($id_max) + 1;

    // добавляем запись для всех вкладок
    for ($xl = 0; $xl < count($lang_all); $xl++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_REGIONS . " SET id=?, country_id=?, name=?, language=?, region_code=?", [$id, $VALID->inGET('country_id'), $VALID->inGET($lang_all[$xl]), $lang_all[$xl], $VALID->inGET('region_code')]);
    }
}

// Если нажали на кнопку Редактировать
if ($VALID->inGET('id_edit')) {

    for ($xl = 0; $xl < count($lang_all); $xl++) {
        // обновляем запись
        $PDO->inPrepare("UPDATE " . TABLE_REGIONS . " SET name=?, region_code=? WHERE id=? AND language=?", [$VALID->inGET('name_edit' . $lang_all[$xl]), $VALID->inGET('region_code_edit'), $VALID->inGET('id_edit'), $lang_all[$xl]]);
    }
}

// Если нажали на кнопку Удалить
if ($VALID->inPOST('delete')) {

    // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_REGIONS . " WHERE country_id=? AND id=?", [$VALID->inPOST('country_id'), $VALID->inPOST('delete')]);
}

//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
$lines = $PDO->getColRow("SELECT id, region_code, name FROM " . TABLE_REGIONS . " WHERE country_id=? AND language=? ORDER BY name", [$VALID->inGET('country_id'), $lang_all[0]]);
$navigate = $NAVIGATOR->goNavi(count($lines), $lines_of_page = 20);
$finish = $navigate[0];
$start = $navigate[1];

// *********  CONNECT PAGE END  ********* //
require_once(ROOT . '/model/end.php');
// ************************************** //

?>