<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$eMarketHandlerSmsc = new \eMarket\Core\Modules\Providers\Smsc();

\eMarket\Core\Routing::jsModulesHandler();

require_once (\eMarket\Core\Routing::modules('view') . '/index.php');
