<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если добавлен новый заказ
if (\eMarket\Valid::inPOST('add') && password_verify(\eMarket\Valid::inPOST('order_total') . \eMarket\Valid::inPOST('products_order') . \eMarket\Valid::inPOST('shipping_method'), \eMarket\Valid::inPOST('hash'))) {
    $customer = \eMarket\Pdo::getColAssoc("SELECT id, address_book, gender, firstname, lastname, middle_name, email, fax, telephone FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    $address_all = json_decode($customer['address_book'], 1);
    //Выбираем адрес
    $address = json_encode($address_all[\eMarket\Valid::inPOST('address') - 1]);
    $customer['address_book'] = $address;

    $orders_status_history_json = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE default_order_status=? AND language=?", [1, lang('#lang_all')[0]]);
    $orders_status_history = json_encode([$orders_status_history_json]);
    
    //Формируем данные по заказу
    $cart = json_decode(\eMarket\Valid::inPOST('products_order'), 1);
    $invoice = [];

    foreach ($cart as $value) {
        $product_data = \eMarket\Products::productData($value['id']);
        $unit = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_UNITS . " WHERE id=? AND language=?", [$product_data['unit'], lang('#lang_all')[0]])[0];
        $data = [
            'name' => $product_data['name'],
            'price' => \eMarket\Products::productPrice($product_data['price'], 1),
            'quantity' => $value['quantity'],
            'unit' => $unit['unit'],
            'amount' => \eMarket\Products::productPrice($product_data['price'] * $value['quantity'], 1),
        ];
        array_push($invoice, $data);
        
        //Вычитаем товар со склада
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_PRODUCTS . " SET quantity=quantity- " . $value['quantity'] . " WHERE id=?", [$value['id']]);
    }

    \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_ORDERS . " SET customer_data=?, orders_status_history=?, products_order=?, order_total=?, currency=?, invoice=?"
            . ", orders_transactions_history=?, customer_ip_address=?, payment_method=?, shipping_method=?, last_modified=?, date_purchased=?",
            [json_encode($customer), $orders_status_history, \eMarket\Valid::inPOST('products_order'), \eMarket\Valid::inPOST('order_total'), $_SESSION['currency_default_catalog'], json_encode($invoice),
                NULL, \eMarket\Set::ipAddress(), \eMarket\Valid::inPOST('payment_method'), \eMarket\Valid::inPOST('shipping_method'), NULL, date("Y-m-d H:i:s")]);
    
    unset($_SESSION['cart']);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>