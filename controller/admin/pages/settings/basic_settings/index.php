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
    
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $lines_on_page = $SET->linesOnPage();
}

// ВРЕМЯ СЕССИИ АДМИНИСТРАТОРА
if ($VALID->inPOST('session_expr_time')) {

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET session_expr_time=?", [$VALID->inPOST('session_expr_time')]);
    
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $session_expr_time = $SET->sessionExprTime();
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */
?>