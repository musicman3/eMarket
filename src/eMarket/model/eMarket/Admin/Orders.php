<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Clock\SystemClock,
    Messages,
    Pages,
    Settings,
    Valid
};
use eMarket\Admin\HeaderMenu;
use Cruder\Db;

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

    public static $routing_parameter = 'orders';
    public $title = 'title_orders_index';
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
    private function edit(): void {
        if (Valid::inPOST('edit')) {

            $primary_language = Settings::primaryLanguage();

            $order_data = Db::connect()
                            ->read(TABLE_ORDERS)
                            ->selectAssoc('orders_status_history, customer_data, email')
                            ->where('id=', Valid::inPOST('edit'))
                            ->save()[0];

            $customer_language = json_decode($order_data['customer_data'], true)['language'];

            $customer_status_history_select = Db::connect()
                    ->read(TABLE_ORDER_STATUS)
                    ->selectValue('name')
                    ->where('language=', $customer_language)
                    ->and('id=', Valid::inPOST('status_history_select'))
                    ->save();

            $admin_status_history_select = Db::connect()
                    ->read(TABLE_ORDER_STATUS)
                    ->selectValue('name')
                    ->where('language=', $primary_language)
                    ->and('id=', Valid::inPOST('status_history_select'))
                    ->save();

            $orders_status_history = json_decode($order_data['orders_status_history'], true);

            if ($orders_status_history[0]['admin']['status'] != $admin_status_history_select) {
                $date = SystemClock::nowSqlDateTime();
                array_unshift($orders_status_history, [
                    'customer' => [
                        'status' => $customer_status_history_select,
                        'date' => SystemClock::getDateTime($date, $customer_language)
                    ],
                    'admin' => [
                        'status' => $admin_status_history_select,
                        'date' => SystemClock::getDateTime($date, $primary_language)
                ]]);

                Db::connect()
                        ->update(TABLE_ORDERS)
                        ->set('orders_status_history', json_encode($orders_status_history))
                        ->set('last_modified', $date)
                        ->where('id=', Valid::inPOST('edit'))
                        ->save();

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
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            Db::connect()
                    ->delete(TABLE_ORDERS)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$order_status = Db::connect()
                ->read(TABLE_ORDER_STATUS)
                ->selectAssoc('*')
                ->where('language=', lang('#lang_all')[0])
                ->orderByDesc('sort')
                ->save();

        $search = '%' . Valid::inGET('search') . '%';
        if (Valid::inGET('search')) {

            self::$sql_data = Db::connect()
                    ->read(TABLE_ORDERS)
                    ->selectAssoc('*')
                    ->where('{{CAST AS CHAR->id}} {{LIKE}} ', $search)
                    ->or('email {{LIKE}} ', $search)
                    ->or('lastname {{LIKE}} ', $search)
                    ->or('firstname {{LIKE}} ', $search)
                    ->or('telephone {{LIKE}} ', $search)
                    ->orderByDesc('id')
                    ->save();
        } else {

            self::$sql_data = Db::connect()
                    ->read(TABLE_ORDERS)
                    ->selectAssoc('*')
                    ->orderByDesc('id')
                    ->save();
        }

        Pages::data(self::$sql_data);
    }

    /**
     * Modal
     *
     */
    private function modal(): void {
        self::$json_data = json_encode([]);
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $sql_modal['date_purchased'] = SystemClock::getDateTime($sql_modal['date_purchased']);
                        $orders[$modal_id] = $sql_modal;
                    }
                }

                self::$json_data = json_encode($orders);
            }
        }
    }

}
