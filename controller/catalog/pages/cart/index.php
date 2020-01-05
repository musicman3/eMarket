<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// JSON ECHO
if (\eMarket\Valid::inPOST('shipping_region_json')) {
    $zones_id = \eMarket\Shipping::shippingZonesAvailable(\eMarket\Valid::inPOST('shipping_region_json')); // список id зон, в которых находится регион
    $modules_names = \eMarket\Shipping::shippingModulesAvailable($zones_id); // данные в виде названия модулей
    $modules_data = \eMarket\Shipping::loadData($zones_id, $modules_names);
    $interface_data = [];
    foreach ($modules_data as $data) {

        // Интерфейс для модулей доставки
        $interface = [
            'chanel_module' => $data['chanel_module'],
            'chanel_name' => $data['chanel_name'],
            'chanel_minimum_price' => $data['chanel_minimum_price'],
            'chanel_shipping_price' => $data['chanel_shipping_price'],
            'chanel_tax' => $data['chanel_tax'],
            'chanel_image' => $data['chanel_image']
        ];

        array_push($interface_data, $interface);
    }
    echo str_replace("'", "&#8216;", json_encode($interface_data));
    exit;
}

$cart_info = \eMarket\Cart::info();

//\eMarket\Debug::trace(\eMarket\Ecb::shippingModulesAvailable('191'));
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>