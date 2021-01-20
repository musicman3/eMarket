<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

$eMarket = new eMarket\Install\Index();

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(getenv('DOCUMENT_ROOT') . '/model/end.php');
/* ------------------------------------------ */