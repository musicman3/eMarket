<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$eMarketDiscountSale = new \eMarket\Core\Modules\Discount\Sale();

\eMarket\Core\Routing::jsModulesHandler();
require_once (\eMarket\Core\Routing::modules('view') . '/index.php');
