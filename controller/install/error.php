<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

if (\eMarket\Valid::inGET('file_configure_not_found')) {
    $message = 'file_configure_not_found';
}
if (\eMarket\Valid::inGET('server_db_error')) {
    $message = 'server_db_error';
}
if (\eMarket\Valid::inGET('file_not_found')) {
    $message = 'file_not_found';
}
if (\eMarket\Valid::inGET('error_message')) {
    $error_message = \eMarket\Valid::inGET('error_message');
    if (strrpos($error_message, 'php_network_getaddresses') == TRUE) {
        $error_message = lang('database_server_error');
    }
    if (strrpos($error_message, 'Access denied for user') == TRUE) {
        $error_message = lang('database_login_error');
    }
    if (strrpos($error_message, 'Unknown database') == TRUE) {
        $error_message = lang('database_table_error');
    }
}

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(getenv('DOCUMENT_ROOT') . '/model/end.php');
/* ------------------------------------------ */

