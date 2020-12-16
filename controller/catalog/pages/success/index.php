<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если добавлен новый заказ
if (\eMarket\Valid::inPOST('add') && password_verify((float) \eMarket\Valid::inPOST('order_total_tax') . (float) \eMarket\Valid::inPOST('order_to_pay') . (float) \eMarket\Valid::inPOST('order_total_with_shipping') . \eMarket\Valid::inPOST('products_order') . \eMarket\Valid::inPOST('shipping_method') . (float) \eMarket\Valid::inPOST('order_shipping_price') . (float) \eMarket\Valid::inPOST('order_total'), \eMarket\Valid::inPOST('hash'))) {
    $customer = \eMarket\Pdo::getColAssoc("SELECT id, address_book, gender, firstname, lastname, middle_name, fax, telephone FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    // Готовим данные по адресу
    $address_all = json_decode($customer['address_book'], 1);
    $address_data = $address_all[\eMarket\Valid::inPOST('address') - 1];
    $address_data['region'] = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_REGIONS . " WHERE id=? AND language=?", [$address_data['regions_id'], lang('#lang_all')[0]]);
    $address_data['country'] = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_COUNTRIES . " WHERE id=? AND language=?", [$address_data['countries_id'], lang('#lang_all')[0]]);

    unset($address_data['default']);
    unset($address_data['regions_id']);
    unset($address_data['countries_id']);

    $customer['address_book'] = json_encode($address_data);
    $customer['language'] = $_SESSION['DEFAULT_LANGUAGE'];
    //Основной язык
    $primary_language = \eMarket\Set::primaryLanguage();

    $customer_orders_status_history = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE default_order_status=? AND language=?", [1, lang('#lang_all')[0]]);
    $admin_orders_status_history = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE default_order_status=? AND language=?", [1, $primary_language]);
    $date = date("Y-m-d H:i:s");
    $orders_status_history_data = [[
    'admin' => [
        'status' => $admin_orders_status_history,
        'date' => \eMarket\Set::dateLocale($date, '%c', $primary_language)
    ],
    'customer' => [
        'status' => $customer_orders_status_history,
        'date' => \eMarket\Set::dateLocale($date, '%c')
    ]
    ]];
    $orders_status_history = json_encode($orders_status_history_data);

    //Формируем данные по заказу
    $cart = json_decode(\eMarket\Valid::inPOST('products_order'), 1);
    $invoice = [];

    $stiker_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [$primary_language]);
    $stiker_name = [];
    foreach ($stiker_data as $val) {
        $stiker_name[$val['id']] = $val['name'];
    }

    $stiker_data_customer = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [lang('#lang_all')[0]]);
    $stiker_name_customer = [];
    foreach ($stiker_data_customer as $val) {
        $stiker_name_customer[$val['id']] = $val['name'];
    }

    foreach ($cart as $value) {
        $product_data = \eMarket\Products::productData($value['id']);
        $admin_product_data = \eMarket\Products::productData($value['id'], $primary_language);
        $unit = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_UNITS . " WHERE id=? AND language=?", [$product_data['unit'], lang('#lang_all')[0]])[0];
        $admin_unit = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_UNITS . " WHERE id=? AND language=?", [$product_data['unit'], $primary_language])[0];

        if (isset($stiker_name[$product_data['stiker']])) {
            $stiker_name_data = $stiker_name[$product_data['stiker']];
        } else {
            $stiker_name_data = '';
        }
        if (isset($stiker_name_customer[$product_data['stiker']])) {
            $stiker_name_customer_data = $stiker_name_customer[$product_data['stiker']];
        } else {
            $stiker_name_customer_data = '';
        }

        $data = [
            'admin' => [
                'name' => $admin_product_data['name'],
                'price' => \eMarket\Ecb::formatPrice(\eMarket\Ecb::outPrice($admin_product_data)['out_price'], 1, $primary_language),
                'unit' => $admin_unit['unit'],
                'amount' => \eMarket\Ecb::formatPrice(\eMarket\Ecb::outPrice($admin_product_data)['out_price'] * $value['quantity'], 1, $primary_language),
                'stiker' => $stiker_name_data
            ],
            'customer' => [
                'name' => $product_data['name'],
                'price' => \eMarket\Ecb::formatPrice(\eMarket\Ecb::outPrice($product_data)['out_price'], 1),
                'unit' => $unit['unit'],
                'amount' => \eMarket\Ecb::formatPrice(\eMarket\Ecb::outPrice($product_data)['out_price'] * $value['quantity'], 1),
                'stiker' => $stiker_name_customer_data
            ],
            'data' => [
                'quantity' => $value['quantity']
            ]
        ];

        array_push($invoice, $data);
    }

    $order_total = [
        'admin' => [
            'total_with_shipping_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_total_with_shipping'), 1, $primary_language),
            'total_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_total'), 1, $primary_language),
            'shipping_price_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_shipping_price'), 1, $primary_language),
            'total_to_pay_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_to_pay'), 1, $primary_language),
            'order_total_tax_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_total_tax'), 1, $primary_language),
            'order_interface_data' => \eMarket\Ecb::priceTerminal('interface', $primary_language)
        ],
        'customer' => [
            'total_with_shipping_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_total_with_shipping'), 1),
            'total_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_total'), 1),
            'shipping_price_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_shipping_price'), 1),
            'total_to_pay_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_to_pay'), 1),
            'order_total_tax_format' => \eMarket\Ecb::formatPrice(\eMarket\Valid::inPOST('order_total_tax'), 1),
            'order_interface_data' => \eMarket\Ecb::priceTerminal('interface', lang('#lang_all')[0])
        ],
        'data' => [
            'total_with_shipping' => \eMarket\Valid::inPOST('order_total_with_shipping'),
            'total' => \eMarket\Valid::inPOST('order_total'),
            'shipping_price' => \eMarket\Valid::inPOST('order_shipping_price'),
            'total_to_pay' => \eMarket\Valid::inPOST('order_to_pay'),
            'order_total_tax' => \eMarket\Valid::inPOST('order_total_tax')
        ]
    ];

    $admin_payment_method = lang('modules_payment_' . \eMarket\Valid::inPOST('payment_method') . '_name', $primary_language, 'all');
    $customer_payment_method = lang('modules_payment_' . \eMarket\Valid::inPOST('payment_method') . '_name');
    $payment_method = json_encode([
        'admin' => $admin_payment_method,
        'customer' => $customer_payment_method
    ]);

    $admin_shipping_method = lang('modules_shipping_' . \eMarket\Valid::inPOST('shipping_method') . '_name', $primary_language, 'all');
    $customer_shipping_method = lang('modules_shipping_' . \eMarket\Valid::inPOST('shipping_method') . '_name');
    $shipping_method = json_encode([
        'admin' => $admin_shipping_method,
        'customer' => $customer_shipping_method
    ]);

    \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_ORDERS . " SET email=?, customer_data=?, orders_status_history=?, products_order=?, order_total=?, invoice=?"
            . ", orders_transactions_history=?, customer_ip_address=?, payment_method=?, shipping_method=?, last_modified=?, date_purchased=?",
            [$_SESSION['email_customer'], json_encode($customer), $orders_status_history, \eMarket\Valid::inPOST('products_order'), json_encode($order_total), json_encode($invoice),
                NULL, \eMarket\Set::ipAddress(), $payment_method, $shipping_method, NULL, date("Y-m-d H:i:s")]);

    //Обновляем таблицу товара
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_PRODUCTS . " SET quantity=quantity- " . $value['quantity'] . ", ordered=ordered+ " . $value['quantity'] . " WHERE id=?", [$value['id']]);

    unset($_SESSION['cart']);

    $customer_order_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE email=? ORDER BY id DESC", [$_SESSION['email_customer']])[0];

    $email_subject = sprintf(lang('email_order_success_subject'), $customer_order_data['id'], $customer_orders_status_history);
    $email_message = sprintf(lang('email_order_success_message'), $customer_order_data['id'], mb_strtolower($customer_orders_status_history), HTTP_SERVER . '?route=success', HTTP_SERVER . '?route=success');
    \eMarket\Messages::sendMail($_SESSION['email_customer'], $email_subject, $email_message);
}

if (\eMarket\Valid::inPOST('add') && !password_verify((float) \eMarket\Valid::inPOST('order_total_tax') . (float) \eMarket\Valid::inPOST('order_to_pay') . (float) \eMarket\Valid::inPOST('order_total_with_shipping') . \eMarket\Valid::inPOST('products_order') . \eMarket\Valid::inPOST('shipping_method') . (float) \eMarket\Valid::inPOST('order_shipping_price') . (float) \eMarket\Valid::inPOST('order_total'), \eMarket\Valid::inPOST('hash'))) {
    echo 'false';
    exit;
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>