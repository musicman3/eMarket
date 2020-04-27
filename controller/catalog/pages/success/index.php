<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если добавлен новый заказ
if (\eMarket\Valid::inPOST('add') && password_verify(\eMarket\Valid::inPOST('order_total') . \eMarket\Valid::inPOST('products_order') . \eMarket\Valid::inPOST('shipping_method'), \eMarket\Valid::inPOST('hash'))) {
    $customer = \eMarket\Pdo::getColAssoc("SELECT id, address_book, gender, firstname, lastname, middle_name, email, fax, telephone FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    // Готовим данные по адресу
    $address_all = json_decode($customer['address_book'], 1);
    $address_data = $address_all[\eMarket\Valid::inPOST('address') - 1];
    $address_data['region'] = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_REGIONS . " WHERE id=? AND language=?", [$address_data['regions_id'], lang('#lang_all')[0]]);
    $address_data['country'] = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_COUNTRIES . " WHERE id=? AND language=?", [$address_data['countries_id'], lang('#lang_all')[0]]);

    unset($address_data['default']);
    unset($address_data['regions_id']);
    unset($address_data['countries_id']);

    $customer['address_book'] = json_encode($address_data);
    //Основной язык
    $primary_language = \eMarket\Set::primaryLanguage();

    $customer_orders_status_history_json = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE default_order_status=? AND language=?", [1, lang('#lang_all')[0]]);
    $admin_orders_status_history_json = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE default_order_status=? AND language=?", [1, $primary_language]);
    $orders_status_history = json_encode([
        'admin' => [$admin_orders_status_history_json],
        'customer' => [$customer_orders_status_history_json]
    ]);

    //Формируем данные по заказу
    $cart = json_decode(\eMarket\Valid::inPOST('products_order'), 1);
    $invoice = [];

    foreach ($cart as $value) {
        $product_data = \eMarket\Products::productData($value['id']);
        $admin_product_data = \eMarket\Products::productData($value['id'], $primary_language);
        $unit = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_UNITS . " WHERE id=? AND language=?", [$product_data['unit'], lang('#lang_all')[0]])[0];
        $admin_unit = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_UNITS . " WHERE id=? AND language=?", [$product_data['unit'], $primary_language])[0];
        $data = [
            'quantity' => $value['quantity'],
            'name' => $product_data['name'],
            'price' => \eMarket\Products::productPrice($product_data['price'], 1),
            'unit' => $unit['unit'],
            'amount' => \eMarket\Products::productPrice($product_data['price'] * $value['quantity'], 1),
            'admin_name' => $admin_product_data['name'],
            'admin_price' => \eMarket\Products::productPrice($admin_product_data['price'], 1, $primary_language),
            'admin_unit' => $admin_unit['unit'],
            'admin_amount' => \eMarket\Products::productPrice($admin_product_data['price'] * $value['quantity'], 1, $primary_language),
        ];
        array_push($invoice, $data);
    }
    $order_total = [
        'total_with_shipping' => \eMarket\Valid::inPOST('order_total_with_shipping'),
        'total_with_shipping_format' => \eMarket\Products::productPrice(\eMarket\Valid::inPOST('order_total_with_shipping'), 1),
        'admin_total_with_shipping_format' => \eMarket\Products::productPrice(\eMarket\Valid::inPOST('order_total_with_shipping'), 1, $primary_language),
        'total' => \eMarket\Valid::inPOST('order_total'),
        'total_format' => \eMarket\Products::productPrice(\eMarket\Valid::inPOST('order_total'), 1),
        'admin_total_format' => \eMarket\Products::productPrice(\eMarket\Valid::inPOST('order_total'), 1, $primary_language),
        'shipping_price' => \eMarket\Valid::inPOST('order_shipping_price'),
        'shipping_price_format' => \eMarket\Products::productPrice(\eMarket\Valid::inPOST('order_shipping_price'), 1),
        'admin_shipping_price_format' => \eMarket\Products::productPrice(\eMarket\Valid::inPOST('order_shipping_price'), 1, $primary_language)
    ];

    $payment_method = lang('modules_payment_' . \eMarket\Valid::inPOST('payment_method') . '_name');
    $shipping_method = lang('modules_shipping_' . \eMarket\Valid::inPOST('shipping_method') . '_name');

    \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_ORDERS . " SET customer_data=?, orders_status_history=?, products_order=?, order_total=?, currency=?, invoice=?"
            . ", orders_transactions_history=?, customer_ip_address=?, payment_method=?, shipping_method=?, last_modified=?, date_purchased=?",
            [json_encode($customer), $orders_status_history, \eMarket\Valid::inPOST('products_order'), json_encode($order_total), $_SESSION['currency_default_catalog'], json_encode($invoice),
                NULL, \eMarket\Set::ipAddress(), $payment_method, $shipping_method, NULL, date("Y-m-d H:i:s")]);

    //Вычитаем товар со склада
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_PRODUCTS . " SET quantity=quantity- " . $value['quantity'] . " WHERE id=?", [$value['id']]);

    unset($_SESSION['cart']);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>