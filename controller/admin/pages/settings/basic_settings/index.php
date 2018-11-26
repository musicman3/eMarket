<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
// 
if ($VALID->inGET('lines_on_page')) {

    // Считаем количество строк
    $lines_on_page_count = $PDO->getRowCount("SELECT lines_on_page FROM " . TABLE_BASIC_SETTINGS, []);

    if ($lines_on_page_count == false) {

        $PDO->inPrepare("INSERT INTO " . TABLE_BASIC_SETTINGS . " SET lines_on_page=?", [$VALID->inGET('lines_on_page')]);
    } elseif ($lines_on_page_count == 1) {
        $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET lines_on_page=?", [$VALID->inGET('lines_on_page')]);
    }
}
// Считываем значение
$lines_on_page = $PDO->selectPrepare("SELECT lines_on_page FROM " . TABLE_BASIC_SETTINGS, []);


/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */
?>