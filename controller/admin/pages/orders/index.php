<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

if (\eMarket\Valid::inPOST('edit')) {

    $primary_language = \eMarket\Settings::primaryLanguage();

    $order_data = \eMarket\Pdo::getColAssoc("SELECT orders_status_history, customer_data, email FROM " . TABLE_ORDERS . " WHERE id=?", [\eMarket\Valid::inPOST('edit')])[0];
    $customer_language = json_decode($order_data['customer_data'], 1)['language'];
    $customer_status_history_select = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE language=? AND id=?", [$customer_language, \eMarket\Valid::inPOST('status_history_select')]);
    $admin_status_history_select = \eMarket\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE language=? AND id=?", [$primary_language, \eMarket\Valid::inPOST('status_history_select')]);

    $orders_status_history = json_decode($order_data['orders_status_history'], 1);

    if ($orders_status_history[0]['admin']['status'] != $admin_status_history_select) {
        $date = date("Y-m-d H:i:s");
        array_unshift($orders_status_history, [
            'customer' => [
                'status' => $customer_status_history_select,
                'date' => \eMarket\Settings::dateLocale($date, '%c', $customer_language)
            ],
            'admin' => [
                'status' => $admin_status_history_select,
                'date' => \eMarket\Settings::dateLocale($date, '%c', $primary_language)
        ]]);
        \eMarket\Pdo::action("UPDATE " . TABLE_ORDERS . " SET orders_status_history=?, last_modified=? WHERE id=?", [json_encode($orders_status_history), $date, \eMarket\Valid::inPOST('edit')]);

        $email_subject = sprintf(lang('orders_change_status_subject'), \eMarket\Valid::inPOST('edit'), $customer_status_history_select);
        $email_message = sprintf(lang('orders_change_status_message'), \eMarket\Valid::inPOST('edit'), mb_strtolower($customer_status_history_select), HTTP_SERVER . '?route=success', HTTP_SERVER . '?route=success');
        \eMarket\Messages::sendMail($order_data['email'], $email_subject, $email_message);
    } else {
        exit;
    }

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}


if (\eMarket\Valid::inPOST('delete')) {

    \eMarket\Pdo::action("DELETE FROM " . TABLE_ORDERS . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

$order_status = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);


$search = '%' . \eMarket\Valid::inGET('search') . '%';
if (\eMarket\Valid::inGET('search')) {
    $lines = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE id LIKE? OR email LIKE? OR customer_data RLIKE? OR customer_data RLIKE? ORDER BY id DESC", [$search, $search, '"lastname": "(?i)([^"])*' . \eMarket\Valid::inGET('search') . '([^"])*', '"firstname": "(?i)([^"])*' . \eMarket\Valid::inGET('search') . '([^"])*']);
} else {
    $lines = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDERS . " ORDER BY id DESC", []);
}

\eMarket\Pages::table($lines);

require_once('modal/index.php');
