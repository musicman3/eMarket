<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inSERVER('REQUEST_URI') == '/') {
    $url_request = HTTP_SERVER . '?route=catalog';
}else{
    $url_request = \eMarket\Valid::inSERVER('REQUEST_URI');
}

if (\eMarket\Valid::inGET('language')) {
    $url_request = \eMarket\Func::deleteGet($url_request, 'language');
}

if (\eMarket\Valid::inGET('currency_default')) {
    $url_request = \eMarket\Func::deleteGet($url_request, 'currency_default');
}


?>