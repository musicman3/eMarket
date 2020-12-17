<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
// КОЛИЧЕСТВО СТРОК НА СТРАНИЦЕ
if (\eMarket\Valid::inPOST('lines_on_page')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET lines_on_page=?", [\eMarket\Valid::inPOST('lines_on_page')]);

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
    // Считываем значение
    $lines_on_page = \eMarket\Settings::linesOnPage();
}

// ВРЕМЯ СЕССИИ АДМИНИСТРАТОРА
if (\eMarket\Valid::inPOST('session_expr_time')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET session_expr_time=?", [\eMarket\Valid::inPOST('session_expr_time')]);

    // Считываем значение
    $session_expr_time = \eMarket\Settings::sessionExprTime();
}

// ОТЛАДОЧНАЯ ИНФОРМАЦИЯ
$debug = \eMarket\Pdo::getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('debug')) {

    if (\eMarket\Valid::inPOST('debug') == lang('debug_on')) {
        $debug_set = 1;
    }
    if (\eMarket\Valid::inPOST('debug') == lang('debug_off')) {
        $debug_set = 0;
    }

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET debug=?", [$debug_set]);

    // Считываем значение
    $debug = \eMarket\Pdo::getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// ОСНОВНОЙ ЯЗЫК
$primary_language = \eMarket\Settings::primaryLanguage();
$langs_settings = \eMarket\Func::deleteValInArray(lang('#lang_all'), [$primary_language]);

if (\eMarket\Valid::inPOST('primary_language')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [\eMarket\Valid::inPOST('primary_language')]);

    // Считываем значение
    $primary_language = \eMarket\Settings::primaryLanguage();
}


// E-Mail
$email = \eMarket\Pdo::getCell("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('email')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET email=?", [\eMarket\Valid::inPOST('email')]);

    // Считываем значение
    $email = \eMarket\Pdo::getCell("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// E-Mail Имя отправителя
$email_name = \eMarket\Pdo::getCell("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('email_name')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET email_name=?", [\eMarket\Valid::inPOST('email_name')]);

    // Считываем значение
    $email_name = \eMarket\Pdo::getCell("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// SMTP статус
$smtp_status = \eMarket\Pdo::getCell("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('smtp_status')) {
    if (\eMarket\Valid::inPOST('smtp_status') == 'on') {
        $smtp_status_set = 1;
    }
    if (\eMarket\Valid::inPOST('smtp_status') == 'off') {
        $smtp_status_set = 0;
    }

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_status=?", [$smtp_status_set]);

    // Считываем значение
    $smtp_status = \eMarket\Pdo::getCell("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// SMTP авторизация
$smtp_auth = \eMarket\Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('smtp_auth')) {

    if (\eMarket\Valid::inPOST('smtp_auth') == lang('debug_on')) {
        $smtp_auth_set = 1;
    }
    if (\eMarket\Valid::inPOST('smtp_auth') == lang('debug_off')) {
        $smtp_auth_set = 0;
    }

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_auth=?", [$smtp_auth_set]);

    // Считываем значение
    $smtp_auth = \eMarket\Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Хост E-Mail
$host_email = \eMarket\Pdo::getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('host_email')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET host_email=?", [\eMarket\Valid::inPOST('host_email')]);

    // Считываем значение
    $host_email = \eMarket\Pdo::getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Логин E-Mail
$username_email = \eMarket\Pdo::getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('username_email')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET username_email=?", [\eMarket\Valid::inPOST('username_email')]);

    // Считываем значение
    $username_email = \eMarket\Pdo::getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Пароль E-Mail
$password_email = \eMarket\Pdo::getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('password_email')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET password_email=?", [\eMarket\Valid::inPOST('password_email')]);

    // Считываем значение
    $password_email = \eMarket\Pdo::getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Защищенное соединение SMTP E-Mail
$smtp_secure = \eMarket\Pdo::getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('smtp_secure')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_secure=?", [\eMarket\Valid::inPOST('smtp_secure')]);

    // Считываем значение
    $smtp_secure = \eMarket\Pdo::getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
}

// Порт SMTP E-Mail
$smtp_port = \eMarket\Pdo::getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('smtp_port')) {

    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_port=?", [\eMarket\Valid::inPOST('smtp_port')]);

    // Считываем значение
    $smtp_port = \eMarket\Pdo::getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
\eMarket\Settings::$JS_END = __DIR__;
?>