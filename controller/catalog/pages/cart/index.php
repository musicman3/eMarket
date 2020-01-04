<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// JSON ECHO
if (\eMarket\Valid::inPOST('shipping_method_json')) {
    $module = \eMarket\Ecb::shippingModulesAvailable(\eMarket\Valid::inPOST('shipping_method_json'));
    $name_module_arr = [];
    $x = 0;
    foreach ($module as $name) {
        $name_module_arr[$x] = [$name, lang('modules_shipping_' . $name . '_name')];
        $x++;
    }
    echo str_replace("'", "&#8216;", json_encode($name_module_arr));
    exit;
}

$cart_info = \eMarket\Cart::info();

//\eMarket\Debug::trace(\eMarket\Ecb::shippingModulesAvailable('191'));
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>