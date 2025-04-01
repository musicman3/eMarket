<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$Checkout = new eMarket\Catalog\Checkout();

use eMarket\Core\{
    Valid
};

if (Valid::inPost('request_callback_type') && Valid::inPost('request_callback_name')) {
    require_once(getenv('DOCUMENT_ROOT') . '/modules/' . Valid::inPost('request_callback_type') . '/' . Valid::inPost('request_callback_name') . '/controller/catalog/index.php');
}