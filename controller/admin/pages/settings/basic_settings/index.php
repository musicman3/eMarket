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

// SMTP авторизация
$smtp = $PDO->getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);

if ($VALID->inPOST('smtp_auth')) {

    if ($VALID->inPOST('smtp_auth') == lang('debug_on')) {
        $smtp_auth_set = 1;
    }
    if ($VALID->inPOST('smtp_auth') == lang('debug_off')) {
        $smtp_auth_set = 0;
    }

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_auth=?", [$smtp_auth_set]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $smtp = $PDO->getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Хост E-Mail
$host_email = $PDO->getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if ($VALID->inPOST('host_email')) {

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET host_email=?", [$VALID->inPOST('host_email')]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $host_email = $PDO->getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Логин E-Mail
$username_email = $PDO->getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if ($VALID->inPOST('username_email')) {

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET username_email=?", [$VALID->inPOST('username_email')]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $username_email = $PDO->getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Пароль E-Mail
$password_email = $PDO->getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if ($VALID->inPOST('password_email')) {

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET password_email=?", [$VALID->inPOST('password_email')]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $password_email = $PDO->getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Защищенное соединение SMTP E-Mail
$smtp_secure = $PDO->getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
if ($VALID->inPOST('smtp_secure')) {

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_secure=?", [$VALID->inPOST('smtp_secure')]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $smtp_secure = $PDO->getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Порт SMTP E-Mail
$smtp_port = $PDO->getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
if ($VALID->inPOST('smtp_port')) {

    $PDO->inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_port=?", [$VALID->inPOST('smtp_port')]);

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    // Считываем значение
    $smtp_port = $PDO->getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>