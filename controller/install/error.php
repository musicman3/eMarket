<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

if ($VALID->inGET('file_configure_not_found')) {
    $message = 'file_configure_not_found';
}
if ($VALID->inGET('server_db_error')) {
    $message = 'server_db_error';
}
if ($VALID->inGET('file_not_found')) {
    $message = 'file_not_found';
}
if ($VALID->inGET('error_message')) {
    $error_message = $VALID->inGET('error_message');
}

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(getenv('DOCUMENT_ROOT') . '/model/end.php');
/* ------------------------------------------ */

?>
