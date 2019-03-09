<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
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

// ОТЛАДОЧНАЯ ИНФОРМАЦИЯ
$debug = $PDO->getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);

if ($VALID->inPOST('debug')) {

    if ($VALID->inPOST('debug') == lang('debug_on')) {
        $debug_set = 1;
    }
    if ($VALID->inPOST('debug') == lang('debug_off')) {
        $debug_set = 0;
    }

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET debug=?", [$debug_set]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $debug = $PDO->getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>