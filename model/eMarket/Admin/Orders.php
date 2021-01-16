<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Orders
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Orders {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $order_status = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->edit();
        $this->delete();
        $this->data();
        $this->modal();
    }
    
    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu() {
        \eMarket\Admin\HeaderMenu::$menu[\eMarket\Admin\HeaderMenu::$menu_sales][] = ['?route=orders', 'glyphicon glyphicon-shopping-cart', lang('title_orders_index'), '', 'false'];
    }    

    /**
     * Edit
     *
     */
    public function edit() {
        if (\eMarket\Core\Valid::inPOST('edit')) {

            $primary_language = \eMarket\Core\Settings::primaryLanguage();

            $order_data = \eMarket\Core\Pdo::getColAssoc("SELECT orders_status_history, customer_data, email FROM " . TABLE_ORDERS . " WHERE id=?", [\eMarket\Core\Valid::inPOST('edit')])[0];
            $customer_language = json_decode($order_data['customer_data'], 1)['language'];
            $customer_status_history_select = \eMarket\Core\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE language=? AND id=?", [$customer_language, \eMarket\Core\Valid::inPOST('status_history_select')]);
            $admin_status_history_select = \eMarket\Core\Pdo::getCellFalse("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE language=? AND id=?", [$primary_language, \eMarket\Core\Valid::inPOST('status_history_select')]);

            $orders_status_history = json_decode($order_data['orders_status_history'], 1);

            if ($orders_status_history[0]['admin']['status'] != $admin_status_history_select) {
                $date = date("Y-m-d H:i:s");
                array_unshift($orders_status_history, [
                    'customer' => [
                        'status' => $customer_status_history_select,
                        'date' => \eMarket\Core\Settings::dateLocale($date, '%c', $customer_language)
                    ],
                    'admin' => [
                        'status' => $admin_status_history_select,
                        'date' => \eMarket\Core\Settings::dateLocale($date, '%c', $primary_language)
                ]]);
                \eMarket\Core\Pdo::action("UPDATE " . TABLE_ORDERS . " SET orders_status_history=?, last_modified=? WHERE id=?", [json_encode($orders_status_history), $date, \eMarket\Core\Valid::inPOST('edit')]);

                $email_subject = sprintf(lang('orders_change_status_subject'), \eMarket\Core\Valid::inPOST('edit'), $customer_status_history_select);
                $email_message = sprintf(lang('orders_change_status_message'), \eMarket\Core\Valid::inPOST('edit'), mb_strtolower($customer_status_history_select), HTTP_SERVER . '?route=success', HTTP_SERVER . '?route=success');
                \eMarket\Core\Messages::sendMail($order_data['email'], $email_subject, $email_message);
            } else {
                exit;
            }

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Core\Valid::inPOST('delete')) {

            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_ORDERS . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$order_status = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);

        $search = '%' . \eMarket\Core\Valid::inGET('search') . '%';
        if (\eMarket\Core\Valid::inGET('search')) {
            self::$sql_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE id LIKE? OR email LIKE? OR customer_data RLIKE? OR customer_data RLIKE? ORDER BY id DESC", [$search, $search, '"lastname": "(?i)([^"])*' . \eMarket\Core\Valid::inGET('search') . '([^"])*', '"firstname": "(?i)([^"])*' . \eMarket\Core\Valid::inGET('search') . '([^"])*']);
        } else {
            self::$sql_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDERS . " ORDER BY id DESC", []);
        }

        \eMarket\Core\Pages::table(self::$sql_data);
    }

    /**
     * Modal
     *
     */
    public function modal() {
        self::$json_data = json_encode([]);
        for ($i = \eMarket\Core\Pages::$start; $i < \eMarket\Core\Pages::$finish; $i++) {
            if (isset(\eMarket\Core\Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = \eMarket\Core\Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $sql_modal['date_purchased'] = \eMarket\Core\Settings::dateLocale($sql_modal['date_purchased'], '%c');
                        $orders[$modal_id] = $sql_modal;
                    }
                }

                self::$json_data = json_encode($orders);
            }
        }
    }

}
