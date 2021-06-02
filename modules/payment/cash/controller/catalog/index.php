<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$eMarketPaymentCash = new \eMarket\Core\Modules\Payment\Cash();

require_once (ROOT . '/modules/payment/' . \eMarket\Core\Valid::inPOST('payment_method') . '/view/catalog/index.php');
