<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// JSON ECHO SHIPPING
if (\eMarket\Valid::inPOST('shipping_region_json')) {
    $zones_id = \eMarket\Shipping::shippingZonesAvailable(\eMarket\Valid::inPOST('shipping_region_json')); // список id зон, в которых находится регион
    $modules_data = \eMarket\Shipping::loadData($zones_id);
    $interface_data = [];
    foreach ($modules_data as $data) {
        
        $order_to_pay = (float) $data['chanel_total_price_with_shipping'] + (float) $data['chanel_total_tax'];
        // Интерфейс для получения данных от модулей доставки
        $interface = [
            'chanel_id' => $data['chanel_id'],
            'chanel_module_name' => $data['chanel_module_name'],
            'chanel_name' => $data['chanel_name'],
            'chanel_total_price' => $data['chanel_total_price'],
            'chanel_total_price_format' => $data['chanel_total_price_format'],
            'chanel_minimum_price' => $data['chanel_minimum_price'],
            'chanel_minimum_price_format' => $data['chanel_minimum_price_format'],
            'chanel_shipping_price' => $data['chanel_shipping_price'],
            'chanel_shipping_price_format' => $data['chanel_shipping_price_format'],
            'chanel_total_price_with_shipping' => $data['chanel_total_price_with_shipping'],
            'chanel_total_price_with_shipping_format' => $data['chanel_total_price_with_shipping_format'],
            'chanel_total_tax' => $data['chanel_total_tax'],
            'chanel_total_tax_format' => $data['chanel_total_tax_format'],
            'chanel_image' => $data['chanel_image'],
            'chanel_order_to_pay' => $order_to_pay,
            'chanel_order_to_pay_format' => \eMarket\Ecb::formatPrice($order_to_pay, 1),
            // Хэш стоимости с учетом доставки
            'chanel_hash' => \eMarket\Autorize::passwordHash((float) $data['chanel_total_tax'] . $order_to_pay . (float) $data['chanel_total_price_with_shipping'] . \eMarket\Valid::inPOST('products_order_json') . $data['chanel_module_name'] . (float) $data['chanel_shipping_price'] . (float) $data['chanel_total_price'])
        ];

        array_push($interface_data, $interface);
    }
    echo json_encode($interface_data);
    exit;
}

// JSON ECHO PAYMENT
if (\eMarket\Valid::inPOST('payment_shipping_json')) {
    $modules_data = \eMarket\Payment::loadData(\eMarket\Valid::inPOST('payment_shipping_json'));

    $interface_data = [];
    foreach ($modules_data as $data) {

        // Интерфейс для получения данных от модулей оплаты
        $interface = [
            'chanel_module_name' => $data['chanel_module_name'],
            'chanel_name' => $data['chanel_name'],
            'chanel_payment_price' => $data['chanel_payment_price'],
            'chanel_payment_currency' => $data['chanel_payment_currency'],
            'chanel_callback_url' => $data['chanel_callback_url'],
            'chanel_callback_type' => $data['chanel_callback_type'],
            'chanel_callback_data' => $data['chanel_callback_data'],
            'chanel_image' => $data['chanel_image']
        ];

        array_push($interface_data, $interface);
    }
    echo json_encode($interface_data);
    exit;
}

$cart_info = \eMarket\Cart::info();

require(ROOT . '/controller/catalog/pages/cart/modal/index.php');

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
\eMarket\Settings::$JS_END = __DIR__;
?>