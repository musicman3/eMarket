<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// Если добавлен новый заказ
if (\eMarket\Valid::inPOST('add')) {

    \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_ORDERS . " SET customer_id=?, address_book=?, orders_status_history=?, orders_products=?, orders_total=?"
            . ", orders_transactions_history=?, customer_ip_address=?, payment_method=?, shipping_method=?, last_modified=?, date_purchased=?", 
            [\eMarket\Valid::inPOST('customer_id'), \eMarket\Valid::inPOST('address'), 4, eMarket\Valid::inPOST('orders_products'), eMarket\Valid::inPOST('orders_total'),
                NULL, NULL, \eMarket\Valid::inPOST('payment_method'), \eMarket\Valid::inPOST('shipping_method'), NULL, NULL]);
}

// Если получен ответ от процессингового центра на изменение статуса
if (\eMarket\Valid::inPOST('callback')) {
    
}
?>