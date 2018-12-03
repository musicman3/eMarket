<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
// 
// КОЛИЧЕСТВО СТРОК НА СТРАНИЦЕ
if ($VALID->inPOST('lines_on_page')) {

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET lines_on_page=?", [$VALID->inPOST('lines_on_page')]);

    // Считываем значение
    $lines_on_page = $SET->linesOnPage();
}

// ВРЕМЯ СЕССИИ АДМИНИСТРАТОРА
if ($VALID->inPOST('session_expr_time')) {

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET session_expr_time=?", [$VALID->inPOST('session_expr_time')]);

    // Считываем значение
    $session_expr_time = $SET->sessionExprTime();
}

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */
?>