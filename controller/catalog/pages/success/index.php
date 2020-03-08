<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если добавлен новый заказ
if (\eMarket\Valid::inPOST('add') && password_verify(\eMarket\Valid::inPOST('order_total') . \eMarket\Valid::inPOST('products_order') . \eMarket\Valid::inPOST('shipping_method'), \eMarket\Valid::inPOST('hash'))) {
    $customer = \eMarket\Pdo::getColAssoc("SELECT id, address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    $address_all = json_decode($customer['address_book'], 1);
    //Выбираем адрес
    $address = json_encode($address_all[\eMarket\Valid::inPOST('address') - 1]);
    
    $orders_status_history_json = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE default_order_status=? AND language=?", [1, lang('#lang_all')[0]]);
    $orders_status_history = json_encode([$orders_status_history_json]);

    \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_ORDERS . " SET customer_id=?, address_book=?, orders_status_history=?, products_order=?, order_total=?"
            . ", orders_transactions_history=?, customer_ip_address=?, payment_method=?, shipping_method=?, last_modified=?, date_purchased=?",
            [$customer['id'], $address, $orders_status_history, eMarket\Valid::inPOST('products_order'), eMarket\Valid::inPOST('order_total'),
                NULL, \eMarket\Set::ipAdress(), \eMarket\Valid::inPOST('payment_method'), \eMarket\Valid::inPOST('shipping_method'), NULL, date("Y-m-d H:i:s")]);
    
    unset($_SESSION['cart']);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>