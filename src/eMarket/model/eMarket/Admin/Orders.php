<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Pages,
    Pdo,
    Settings,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Orders
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
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
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_sales][] = ['?route=orders', 'bi-basket2', lang('title_orders_index'), '', 'false'];
    }

    /**
     * Edit
     *
     */
    public function edit(): void {
        if (Valid::inPOST('edit')) {

            $primary_language = Settings::primaryLanguage();

            $order_data = Pdo::getAssoc("SELECT orders_status_history, customer_data, email FROM " . TABLE_ORDERS . " WHERE id=?", [
                        Valid::inPOST('edit')])[0];

            $customer_language = json_decode($order_data['customer_data'], true)['language'];

            $customer_status_history_select = Pdo::getValue("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE language=? AND id=?", [
                        $customer_language, Valid::inPOST('status_history_select')
            ]);

            $admin_status_history_select = Pdo::getValue("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE language=? AND id=?", [
                        $primary_language, Valid::inPOST('status_history_select')
            ]);

            $orders_status_history = json_decode($order_data['orders_status_history'], true);

            if ($orders_status_history[0]['admin']['status'] != $admin_status_history_select) {
                $date = date("Y-m-d H:i:s");
                array_unshift($orders_status_history, [
                    'customer' => [
                        'status' => $customer_status_history_select,
                        'date' => Settings::dateLocale($date, '%c', $customer_language)
                    ],
                    'admin' => [
                        'status' => $admin_status_history_select,
                        'date' => Settings::dateLocale($date, '%c', $primary_language)
                ]]);

                Pdo::action("UPDATE " . TABLE_ORDERS . " SET orders_status_history=?, last_modified=? WHERE id=?", [
                    json_encode($orders_status_history), $date, Valid::inPOST('edit')
                ]);

                $email_subject = sprintf(lang('orders_change_status_subject'), Valid::inPOST('edit'), $customer_status_history_select);
                $email_message = sprintf(lang('orders_change_status_message'), Valid::inPOST('edit'), mb_strtolower($customer_status_history_select), HTTP_SERVER . '?route=success', HTTP_SERVER . '?route=success');
                $providers_message = sprintf(lang('orders_change_status_message_providers'), Valid::inPOST('edit'), $customer_status_history_select);
                Messages::sendMail($order_data['email'], $email_subject, $email_message);
                Messages::sendProviders(json_decode($order_data['customer_data'], true)['telephone'], $providers_message);
            } else {
                exit;
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {

            Pdo::action("DELETE FROM " . TABLE_ORDERS . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        self::$order_status = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);

        $search = '%' . Valid::inGET('search') . '%';
        if (Valid::inGET('search')) {

            self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE id LIKE? OR email LIKE? OR customer_data RLIKE? OR customer_data RLIKE? ORDER BY id DESC", [
                        $search, $search, '"lastname": "(?i)([^"])*' . Valid::inGET('search') . '([^"])*', '"firstname": "(?i)([^"])*' .
                        Valid::inGET('search') . '([^"])*'
            ]);
        } else {
            self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDERS . " ORDER BY id DESC", []);
        }

        Pages::data(self::$sql_data);
    }

    /**
     * Modal
     *
     */
    public function modal(): void {
        self::$json_data = json_encode([]);
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $sql_modal['date_purchased'] = Settings::dateLocale($sql_modal['date_purchased'], '%c');
                        $orders[$modal_id] = $sql_modal;
                    }
                }

                self::$json_data = json_encode($orders);
            }
        }
    }

}
