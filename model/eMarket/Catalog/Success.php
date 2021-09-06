<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use eMarket\Core\{
    Ecb,
    Interfaces,
    Messages,
    Pdo,
    Products,
    Settings,
    Valid
};

/**
 * Success
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Success {

    public static $customer_orders_status_history;
    public static $customer;
    public static $orders_status_history;
    public static $order_total;
    public static $invoice;
    public static $payment_method;
    public static $shipping_method;
    public static $primary_language;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->data();
        $this->verify();
    }

    /**
     * Data
     *
     */
    public function data() {
        if (Valid::inPOST('add') && password_verify((float) Valid::inPOST('order_total_tax') . (float) Valid::inPOST('order_to_pay') .
                        (float) Valid::inPOST('order_total_with_shipping') . Valid::inPOST('products_order') . Valid::inPOST('shipping_method') .
                        (float) Valid::inPOST('order_shipping_price') . (float) Valid::inPOST('order_total'), Valid::inPOST('hash'))) {
            self::$customer = Pdo::getAssoc("SELECT id, address_book, gender, firstname, lastname, middle_name, fax, telephone FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];

            $address_all = json_decode(self::$customer['address_book'], 1);
            $address_data = $address_all[Valid::inPOST('address') - 1];
            $address_data['region'] = Pdo::getValue("SELECT name FROM " . TABLE_REGIONS . " WHERE id=? AND language=?", [$address_data['regions_id'], lang('#lang_all')[0]]);
            $address_data['country'] = Pdo::getValue("SELECT name FROM " . TABLE_COUNTRIES . " WHERE id=? AND language=?", [$address_data['countries_id'], lang('#lang_all')[0]]);

            unset($address_data['default']);
            unset($address_data['regions_id']);
            unset($address_data['countries_id']);

            self::$customer['address_book'] = json_encode($address_data);
            self::$customer['language'] = lang('#lang_all')[0];

            self::$primary_language = Settings::primaryLanguage();

            self::$customer_orders_status_history = Pdo::getValue("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE default_order_status=? AND language=?", [1, lang('#lang_all')[0]]);
            $admin_orders_status_history = Pdo::getValue("SELECT name FROM " . TABLE_ORDER_STATUS . " WHERE default_order_status=? AND language=?", [1, self::$primary_language]);
            $date = date("Y-m-d H:i:s");
            $orders_status_history_data = [[
            'admin' => [
                'status' => $admin_orders_status_history,
                'date' => Settings::dateLocale($date, '%c', self::$primary_language)
            ],
            'customer' => [
                'status' => self::$customer_orders_status_history,
                'date' => Settings::dateLocale($date, '%c')
            ]
            ]];
            self::$orders_status_history = json_encode($orders_status_history_data);

            $this->invoice();
            $this->orderTotalData();
            $this->paymentData();
            $this->shippingData();
            $this->save();
            $this->end();
        }
    }

    /**
     * Invoice
     *
     */
    public function invoice() {
        $cart = json_decode(Valid::inPOST('products_order'), 1);

        $sticker_data = Pdo::getAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [self::$primary_language]);
        $sticker_name = [];
        foreach ($sticker_data as $val) {
            $sticker_name[$val['id']] = $val['name'];
        }

        $sticker_data_customer = Pdo::getAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [lang('#lang_all')[0]]);
        $sticker_name_customer = [];
        foreach ($sticker_data_customer as $val) {
            $sticker_name_customer[$val['id']] = $val['name'];
        }

        $INTERFACE = new Interfaces();
        self::$invoice = [];

        foreach ($cart as $value) {
            $product_data = Products::productData($value['id']);
            $admin_product_data = Products::productData($value['id'], self::$primary_language);
            $unit = Pdo::getAssoc("SELECT * FROM " . TABLE_UNITS . " WHERE id=? AND language=?", [$product_data['unit'], lang('#lang_all')[0]])[0];
            $admin_unit = Pdo::getAssoc("SELECT * FROM " . TABLE_UNITS . " WHERE id=? AND language=?", [$product_data['unit'], self::$primary_language])[0];

            if (isset($sticker_name[$product_data['sticker']])) {
                $sticker_name_data = $sticker_name[$product_data['sticker']];
            } else {
                $sticker_name_data = '';
            }
            if (isset($sticker_name_customer[$product_data['sticker']])) {
                $sticker_name_customer_data = $sticker_name_customer[$product_data['sticker']];
            } else {
                $sticker_name_customer_data = '';
            }

            Ecb::discountHandler($admin_product_data);

            $data['admin'] = [
                'name' => $admin_product_data['name'],
                'price' => Ecb::formatPrice($INTERFACE->load('discountHandler', 'data', 'out_price'), 1, self::$primary_language),
                'unit' => $admin_unit['unit'],
                'amount' => Ecb::formatPrice($INTERFACE->load('discountHandler', 'data', 'out_price') * $value['quantity'], 1, self::$primary_language),
                'sticker' => $sticker_name_data
            ];

            Ecb::discountHandler($product_data);

            $data['customer'] = [
                'name' => $product_data['name'],
                'price' => Ecb::formatPrice($INTERFACE->load('discountHandler', 'data', 'out_price'), 1),
                'unit' => $unit['unit'],
                'amount' => Ecb::formatPrice($INTERFACE->load('discountHandler', 'data', 'out_price') * $value['quantity'], 1),
                'sticker' => $sticker_name_customer_data
            ];

            $data['data'] = [
                'quantity' => $value['quantity']
            ];

            array_push(self::$invoice, $data);

            Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET quantity=quantity- " . $value['quantity'] . ", ordered=ordered+ " . $value['quantity'] . " WHERE id=?", [$value['id']]);
        }
    }

    /**
     * Order Total Data
     *
     */
    public function orderTotalData() {
        $INTERFACE = new Interfaces();
        Ecb::priceTerminal(self::$primary_language);
        self::$order_total['admin'] = [
            'total_with_shipping_format' => Ecb::formatPrice(Valid::inPOST('order_total_with_shipping'), 1, self::$primary_language),
            'total_format' => Ecb::formatPrice(Valid::inPOST('order_total'), 1, self::$primary_language),
            'shipping_price_format' => Ecb::formatPrice(Valid::inPOST('order_shipping_price'), 1, self::$primary_language),
            'total_to_pay_format' => Ecb::formatPrice(Valid::inPOST('order_to_pay'), 1, self::$primary_language),
            'order_total_tax_format' => Ecb::formatPrice(Valid::inPOST('order_total_tax'), 1, self::$primary_language),
            'order_interface_data' => $INTERFACE->load('priceTerminal', 'data')
        ];

        Ecb::priceTerminal(lang('#lang_all')[0]);
        self::$order_total['customer'] = [
            'total_with_shipping_format' => Ecb::formatPrice(Valid::inPOST('order_total_with_shipping'), 1),
            'total_format' => Ecb::formatPrice(Valid::inPOST('order_total'), 1),
            'shipping_price_format' => Ecb::formatPrice(Valid::inPOST('order_shipping_price'), 1),
            'total_to_pay_format' => Ecb::formatPrice(Valid::inPOST('order_to_pay'), 1),
            'order_total_tax_format' => Ecb::formatPrice(Valid::inPOST('order_total_tax'), 1),
            'order_interface_data' => $INTERFACE->load('priceTerminal', 'data')
        ];

        self::$order_total['data'] = [
            'total_with_shipping' => Valid::inPOST('order_total_with_shipping'),
            'total' => Valid::inPOST('order_total'),
            'shipping_price' => Valid::inPOST('order_shipping_price'),
            'total_to_pay' => Valid::inPOST('order_to_pay'),
            'order_total_tax' => Valid::inPOST('order_total_tax'),
            'currency' => Pdo::getValue("SELECT id FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [self::$primary_language, 1])
        ];
    }

    /**
     * Payment Data
     *
     */
    public function paymentData() {
        $admin_payment_method = lang('modules_payment_' . Valid::inPOST('payment_method') . '_name', self::$primary_language, 'all');
        $customer_payment_method = lang('modules_payment_' . Valid::inPOST('payment_method') . '_name');
        self::$payment_method = json_encode([
            'admin' => $admin_payment_method,
            'customer' => $customer_payment_method
        ]);
    }

    /**
     * Shipping Data
     *
     */
    public function shippingData() {
        $admin_shipping_method = lang('modules_shipping_' . Valid::inPOST('shipping_method') . '_name', self::$primary_language, 'all');
        $customer_shipping_method = lang('modules_shipping_' . Valid::inPOST('shipping_method') . '_name');
        self::$shipping_method = json_encode([
            'admin' => $admin_shipping_method,
            'customer' => $customer_shipping_method
        ]);
    }

    /**
     * Save
     *
     */
    public function save() {
        Pdo::action("INSERT INTO " . TABLE_ORDERS . " SET email=?, customer_data=?, orders_status_history=?, products_order=?, order_total=?, invoice=?"
                . ", orders_transactions_history=?, customer_ip_address=?, payment_method=?, shipping_method=?, last_modified=?, date_purchased=?",
                [$_SESSION['email_customer'], json_encode(self::$customer), self::$orders_status_history, Valid::inPOST('products_order'), json_encode(self::$order_total), json_encode(self::$invoice),
                    NULL, Settings::ipAddress(), self::$payment_method, self::$shipping_method, NULL, date("Y-m-d H:i:s")]);

        unset($_SESSION['cart']);
    }

    /**
     * End
     *
     */
    public function end() {
        $customer_order_data = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDERS . " WHERE email=? ORDER BY id DESC", [$_SESSION['email_customer']])[0];

        $email_subject = sprintf(lang('email_order_success_subject'), $customer_order_data['id'], self::$customer_orders_status_history);
        $email_message = sprintf(lang('email_order_success_message'), $customer_order_data['id'], mb_strtolower(self::$customer_orders_status_history), HTTP_SERVER . '?route=success', HTTP_SERVER . '?route=success');
        $providers_message = sprintf(lang('providers_order_success'), $customer_order_data['id'], self::$customer_orders_status_history);
        Messages::sendMail($_SESSION['email_customer'], $email_subject, $email_message);
        Messages::sendProviders(json_decode($customer_order_data['customer_data'], 1)['telephone'], $providers_message);
    }

    /**
     * Verify
     *
     */
    public function verify() {
        if (Valid::inPOST('add') && !password_verify((float) Valid::inPOST('order_total_tax') . (float) Valid::inPOST('order_to_pay') .
                        (float) Valid::inPOST('order_total_with_shipping') . Valid::inPOST('products_order') .
                        Valid::inPOST('shipping_method') . (float) Valid::inPOST('order_shipping_price') .
                        (float) Valid::inPOST('order_total'), Valid::inPOST('hash'))) {
            echo 'false';
            exit;
        }
    }

}
