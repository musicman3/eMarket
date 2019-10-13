<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */
//Если не переключали язык
if (!\eMarket\Core\Valid::inPOST('language') && \eMarket\Core\Set::path() == 'install') {
    $DEFAULT_LANGUAGE = 'russian';
}
//Если переключили язык
if (\eMarket\Core\Valid::inPOST('language')) {
    $DEFAULT_LANGUAGE = \eMarket\Core\Valid::inPOST('language');
}
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(getenv('DOCUMENT_ROOT') . '/model/end.php');
/* ------------------------------------------ */

?>