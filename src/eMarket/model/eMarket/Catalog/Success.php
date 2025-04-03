<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Cache,
    Clock\SystemClock,
    Cryptography,
    Ecb,
    DataBuffer,
    Messages,
    Products,
    Settings,
    Valid
};
use Cruder\Db;

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

    public static $routing_parameter = 'success';
    public $title = 'title_success_index';
    public static $customer_orders_status_history;
    public static $customer;
    public static $orders_status_history;
    public static $order_total;
    public static $invoice;
    public static $payment_method;
    public static $shipping_method;
    public static $primary_language;
    public static $customer_email;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->data();
        $this->verify();
    }

    /**
     * Customer data
     *
     */
    private function customerInit(): void {
        if (isset($_SESSION['without_registration_data'])) {
            $without_registration_user = json_decode($_SESSION['without_registration_user'], true)[0];
            self::$customer = [
                'id' => '',
                'address_book' => $_SESSION['without_registration_data'],
                'gender' => '',
                'firstname' => $without_registration_user['firstname'],
                'lastname' => $without_registration_user['lastname'],
                'middle_name' => '',
                'fax' => '',
                'telephone' => $without_registration_user['telephone']
            ];
            self::$customer_email = ' ';
        } else {
            self::$customer_email = $_SESSION['customer_email'];

            self::$customer = Db::connect()
                            ->read(TABLE_CUSTOMERS)
                            ->selectAssoc('id, address_book, gender, firstname, lastname, middle_name, fax, telephone')
                            ->where('email=', self::$customer_email)
                            ->save()[0];
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        if (Valid::inPOST('add') && password_verify((float) Valid::inPOST('order_total_tax') . (float) Valid::inPOST('order_to_pay') .
                        (float) Valid::inPOST('order_total_with_shipping') . Valid::inPOST('products_order') . Valid::inPOST('shipping_method') .
                        (float) Valid::inPOST('order_shipping_price') . (float) Valid::inPOST('order_total'), Valid::inPOST('hash'))) {
            $this->customerInit();

            $address_all = json_decode(self::$customer['address_book'], true);
            $address_data = $address_all[Valid::inPOST('address') - 1];

            $address_data['region'] = Db::connect()
                    ->read(TABLE_REGIONS)
                    ->selectValue('name')
                    ->where('id=', $address_data['regions_id'])
                    ->and('language=', lang('#lang_all')[0])
                    ->save();

            $address_data['country'] = Db::connect()
                    ->read(TABLE_COUNTRIES)
                    ->selectValue('name')
                    ->where('id=', $address_data['countries_id'])
                    ->and('language=', lang('#lang_all')[0])
                    ->save();

            unset($address_data['default']);
            unset($address_data['regions_id']);
            unset($address_data['countries_id']);

            self::$customer['address_book'] = json_encode($address_data);
            self::$customer['language'] = lang('#lang_all')[0];

            self::$primary_language = Settings::primaryLanguage();

            self::$customer_orders_status_history = Db::connect()
                    ->read(TABLE_ORDER_STATUS)
                    ->selectValue('name')
                    ->where('default_order_status=', 1)
                    ->and('language=', lang('#lang_all')[0])
                    ->save();

            $admin_orders_status_history = Db::connect()
                    ->read(TABLE_ORDER_STATUS)
                    ->selectValue('name')
                    ->where('default_order_status=', 1)
                    ->and('language=', self::$primary_language)
                    ->save();

            $date = SystemClock::nowSqlDateTime();
            $orders_status_history_data = [[
            'admin' => [
                'status' => $admin_orders_status_history,
                'date' => SystemClock::getDateTime($date, self::$primary_language)
            ],
            'customer' => [
                'status' => self::$customer_orders_status_history,
                'date' => SystemClock::getDateTime($date)
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
    private function invoice(): void {
        $cart = json_decode(Valid::inPOST('products_order'), true);

        $sticker_data = Db::connect()
                ->read(TABLE_STICKERS)
                ->selectAssoc('*')
                ->where('language=', self::$primary_language)
                ->save();

        $sticker_name = [];
        foreach ($sticker_data as $val) {
            $sticker_name[$val['id']] = $val['name'];
        }

        $sticker_data_customer = Db::connect()
                ->read(TABLE_STICKERS)
                ->selectAssoc('*')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        $sticker_name_customer = [];
        foreach ($sticker_data_customer as $val) {
            $sticker_name_customer[$val['id']] = $val['name'];
        }

        $DataBuffer = new DataBuffer();
        self::$invoice = [];

        foreach ($cart as $value) {
            $product_data = Products::productData($value['id']);
            $admin_product_data = Products::productData($value['id'], self::$primary_language);

            $unit = Db::connect()
                            ->read(TABLE_UNITS)
                            ->selectAssoc('*')
                            ->where('id=', $product_data['unit'])
                            ->and('language=', lang('#lang_all')[0])
                            ->save()[0];

            $admin_unit = Db::connect()
                            ->read(TABLE_UNITS)
                            ->selectAssoc('*')
                            ->where('id=', $product_data['unit'])
                            ->and('language=', self::$primary_language)
                            ->save()[0];

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
                'id' => $admin_product_data['id'],
                'price' => Ecb::formatPrice($DataBuffer->load('discountHandler', 'data', 'out_price'), 1, self::$primary_language),
                'unit' => $admin_unit['unit'],
                'amount' => Ecb::formatPrice($DataBuffer->load('discountHandler', 'data', 'out_price') * $value['quantity'], 1, self::$primary_language),
                'sticker' => $sticker_name_data
            ];

            Ecb::discountHandler($product_data);

            $data['customer'] = [
                'name' => $product_data['name'],
                'id' => $admin_product_data['id'],
                'price' => Ecb::formatPrice($DataBuffer->load('discountHandler', 'data', 'out_price'), 1),
                'unit' => $unit['unit'],
                'amount' => Ecb::formatPrice($DataBuffer->load('discountHandler', 'data', 'out_price') * $value['quantity'], 1),
                'sticker' => $sticker_name_customer_data
            ];

            $data['data'] = [
                'quantity' => $value['quantity']
            ];

            array_push(self::$invoice, $data);

            $Cache = new Cache();
            $Cache->deleteItem('core.products_' . $value['id']);

            Db::connect()
                    ->update(TABLE_PRODUCTS)
                    ->set('quantity', $product_data['quantity'] - $value['quantity'])
                    ->set('ordered', $product_data['ordered'] + $value['quantity'])
                    ->where('id=', $value['id'])
                    ->save();
        }
    }

    /**
     * Order Total Data
     *
     */
    private function orderTotalData(): void {
        $DataBuffer = new DataBuffer();
        Ecb::priceTerminal(self::$primary_language);
        self::$order_total['admin'] = [
            'total_with_shipping_format' => Ecb::formatPrice(Valid::inPOST('order_total_with_shipping'), 1, self::$primary_language),
            'total_format' => Ecb::formatPrice(Valid::inPOST('order_total'), 1, self::$primary_language),
            'shipping_price_format' => Ecb::formatPrice(Valid::inPOST('order_shipping_price'), 1, self::$primary_language),
            'total_to_pay_format' => Ecb::formatPrice(Valid::inPOST('order_to_pay'), 1, self::$primary_language),
            'order_total_tax_format' => Ecb::formatPrice(Valid::inPOST('order_total_tax'), 1, self::$primary_language),
            'order_interface_data' => $DataBuffer->load('priceTerminal', 'data')
        ];

        Ecb::priceTerminal(lang('#lang_all')[0]);
        self::$order_total['customer'] = [
            'total_with_shipping_format' => Ecb::formatPrice(Valid::inPOST('order_total_with_shipping'), 1),
            'total_format' => Ecb::formatPrice(Valid::inPOST('order_total'), 1),
            'shipping_price_format' => Ecb::formatPrice(Valid::inPOST('order_shipping_price'), 1),
            'total_to_pay_format' => Ecb::formatPrice(Valid::inPOST('order_to_pay'), 1),
            'order_total_tax_format' => Ecb::formatPrice(Valid::inPOST('order_total_tax'), 1),
            'order_interface_data' => $DataBuffer->load('priceTerminal', 'data')
        ];

        self::$order_total['data'] = [
            'total_with_shipping' => Valid::inPOST('order_total_with_shipping'),
            'total' => Valid::inPOST('order_total'),
            'shipping_price' => Valid::inPOST('order_shipping_price'),
            'total_to_pay' => Valid::inPOST('order_to_pay'),
            'order_total_tax' => Valid::inPOST('order_total_tax'),
            'currency' => Db::connect()
                    ->read(TABLE_CURRENCIES)
                    ->selectValue('id')
                    ->where('language=', self::$primary_language)
                    ->and('default_value=', 1)
                    ->orderByDesc('id')
                    ->save()
        ];
    }

    /**
     * Payment Data
     *
     */
    private function paymentData(): void {
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
    private function shippingData(): void {
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
    private function save(): void {
        Db::connect()
                ->create(TABLE_ORDERS)
                ->set('email', self::$customer_email)
                ->set('customer_data', json_encode(self::$customer))
                ->set('lastname', self::$customer['lastname'])
                ->set('firstname', self::$customer['firstname'])
                ->set('telephone', self::$customer['telephone'])
                ->set('orders_status_history', self::$orders_status_history)
                ->set('products_order', Valid::inPOST('products_order'))
                ->set('order_total', json_encode(self::$order_total))
                ->set('invoice', json_encode(self::$invoice))
                ->set('orders_transactions_history', NULL)
                ->set('customer_ip_address', Settings::ipAddress())
                ->set('payment_method', self::$payment_method)
                ->set('shipping_method', self::$shipping_method)
                ->set('last_modified', NULL)
                ->set('date_purchased', SystemClock::nowSqlDateTime())
                ->set('uid', Cryptography::getToken(64))
                ->save();

        unset($_SESSION['cart']);
    }

    /**
     * End
     *
     */
    private function end(): void {

        $last_insert_id = Db::connect()->lastInsertId()->save();
        $customer_order_data = Db::connect()
                        ->read(TABLE_ORDERS)
                        ->selectAssoc('*')
                        ->where('id=', $last_insert_id)
                        ->orderByDesc('id')
                        ->save()[0];

        $email_subject = sprintf(lang('email_order_success_subject'), $customer_order_data['id'], self::$customer_orders_status_history);
        $email_message = sprintf(lang('email_order_success_message'), $customer_order_data['id'], mb_strtolower(self::$customer_orders_status_history), HTTP_SERVER . '?route=orders', HTTP_SERVER . '?route=orders');
        $providers_message = sprintf(lang('providers_order_success'), $customer_order_data['id'], self::$customer_orders_status_history);
        Messages::sendMail(self::$customer_email, $email_subject, $email_message);
        Messages::sendProviders(json_decode($customer_order_data['customer_data'], true)['telephone'], $providers_message);
    }

    /**
     * Verify
     *
     */
    private function verify(): void {
        if (Valid::inPOST('add') && !password_verify((float) Valid::inPOST('order_total_tax') . (float) Valid::inPOST('order_to_pay') .
                        (float) Valid::inPOST('order_total_with_shipping') . Valid::inPOST('products_order') .
                        Valid::inPOST('shipping_method') . (float) Valid::inPOST('order_shipping_price') .
                        (float) Valid::inPOST('order_total'), Valid::inPOST('hash'))) {
            echo 'false';
            exit;
        }
    }

}
