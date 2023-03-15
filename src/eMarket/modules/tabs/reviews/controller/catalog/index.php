<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$eMarketTabsReviews = new \eMarket\Core\Modules\Tabs\Reviews();

\eMarket\Core\Routing::jsModulesHandler('tabs/reviews');

require_once (ROOT . '/modules/tabs/reviews/view/catalog/index.php');
