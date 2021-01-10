<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
if (\eMarket\Valid::inPOST('lines_on_page')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET lines_on_page=?", [\eMarket\Valid::inPOST('lines_on_page')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));

    $lines_on_page = \eMarket\Settings::linesOnPage();
}

if (\eMarket\Valid::inPOST('session_expr_time')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET session_expr_time=?", [\eMarket\Valid::inPOST('session_expr_time')]);

    $session_expr_time = \eMarket\Settings::sessionExprTime();
}

$debug = \eMarket\Pdo::getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('debug')) {

    if (\eMarket\Valid::inPOST('debug') == lang('debug_on')) {
        $debug_set = 1;
    }
    if (\eMarket\Valid::inPOST('debug') == lang('debug_off')) {
        $debug_set = 0;
    }

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET debug=?", [$debug_set]);

    $debug = \eMarket\Pdo::getCell("SELECT debug FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$primary_language = \eMarket\Settings::primaryLanguage();
$langs_settings = \eMarket\Func::deleteValInArray(lang('#lang_all'), [$primary_language]);

if (\eMarket\Valid::inPOST('primary_language')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET primary_language=?", [\eMarket\Valid::inPOST('primary_language')]);

    $primary_language = \eMarket\Settings::primaryLanguage();
}


$email = \eMarket\Pdo::getCell("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('email')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET email=?", [\eMarket\Valid::inPOST('email')]);

    $email = \eMarket\Pdo::getCell("SELECT email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$email_name = \eMarket\Pdo::getCell("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('email_name')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET email_name=?", [\eMarket\Valid::inPOST('email_name')]);

    $email_name = \eMarket\Pdo::getCell("SELECT email_name FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$smtp_status = \eMarket\Pdo::getCell("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('smtp_status')) {
    if (\eMarket\Valid::inPOST('smtp_status') == 'on') {
        $smtp_status_set = 1;
    }
    if (\eMarket\Valid::inPOST('smtp_status') == 'off') {
        $smtp_status_set = 0;
    }

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_status=?", [$smtp_status_set]);

    $smtp_status = \eMarket\Pdo::getCell("SELECT smtp_status FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$smtp_auth = \eMarket\Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('smtp_auth')) {

    if (\eMarket\Valid::inPOST('smtp_auth') == lang('debug_on')) {
        $smtp_auth_set = 1;
    }
    if (\eMarket\Valid::inPOST('smtp_auth') == lang('debug_off')) {
        $smtp_auth_set = 0;
    }

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_auth=?", [$smtp_auth_set]);

    $smtp_auth = \eMarket\Pdo::getCell("SELECT smtp_auth FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$host_email = \eMarket\Pdo::getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('host_email')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET host_email=?", [\eMarket\Valid::inPOST('host_email')]);

    $host_email = \eMarket\Pdo::getCell("SELECT host_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$username_email = \eMarket\Pdo::getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('username_email')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET username_email=?", [\eMarket\Valid::inPOST('username_email')]);

    $username_email = \eMarket\Pdo::getCell("SELECT username_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$password_email = \eMarket\Pdo::getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('password_email')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET password_email=?", [\eMarket\Valid::inPOST('password_email')]);

    $password_email = \eMarket\Pdo::getCell("SELECT password_email FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$smtp_secure = \eMarket\Pdo::getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('smtp_secure')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_secure=?", [\eMarket\Valid::inPOST('smtp_secure')]);

    $smtp_secure = \eMarket\Pdo::getCell("SELECT smtp_secure FROM " . TABLE_BASIC_SETTINGS . "", []);
}

$smtp_port = \eMarket\Pdo::getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
if (\eMarket\Valid::inPOST('smtp_port')) {

    \eMarket\Pdo::action("UPDATE " . TABLE_BASIC_SETTINGS . " SET smtp_port=?", [\eMarket\Valid::inPOST('smtp_port')]);

    $smtp_port = \eMarket\Pdo::getCell("SELECT smtp_port FROM " . TABLE_BASIC_SETTINGS . "", []);
}
