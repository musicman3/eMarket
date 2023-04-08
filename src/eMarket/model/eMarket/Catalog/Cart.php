<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Cryptography,
    Ecb,
    Func,
    DataBuffer,
    Payment,
    Pdo,
    Shipping,
    Valid
};

/**
 * Cart
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Cart {

    public static $routing_parameter = 'cart';
    public $title = 'title_cart_index';
    public static $cart_info = FALSE;
    public static $address_data = FALSE;
    public static $products_order = FALSE;
    public static $address_data_json = FALSE;
    public static $total_quantity = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->addProduct();
        $this->editProduct();
        $this->deleteProduct();
        $this->jsonEchoShipping();
        $this->jsonEchoPayment();
        $this->data();
        $this->modal();
    }

    /**
     * Add product to cart
     */
    private function addProduct(): void {

        if (Valid::inGET('add_to_cart') || Valid::inPostJson('add_to_cart')) {
            if (Valid::inGET('add_to_cart')) {
                $id = Valid::inGET('add_to_cart');
            }
            if (Valid::inPostJson('add_to_cart')) {
                $id = Valid::inPostJson('add_to_cart');
            }

            if (!Valid::inGET('add_quantity') && !Valid::inPostJson('add_quantity')) {
                $quantity = 1;
            }
            if (Valid::inGET('add_quantity')) {
                $quantity = Valid::inGET('add_quantity');
            }
            if (Valid::inPostJson('add_quantity')) {
                $quantity = Valid::inPostJson('add_quantity');
            }

            $count = 0;
            if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
                $_SESSION['cart'] = [['id' => $id, 'quantity' => $quantity]];
            } else {

                $id_count = Func::filterArrayToKey($_SESSION['cart'], 'id', $id, 'id');
                foreach ($_SESSION['cart'] as $value) {
                    if ($value['id'] == $id) {
                        $_SESSION['cart'][$count]['quantity'] = $_SESSION['cart'][$count]['quantity'] + $quantity;
                    }

                    $count++;
                }
                if ($value['id'] != $id && count($id_count) == 0) {
                    array_push($_SESSION['cart'], ['id' => $id, 'quantity' => $quantity]);
                }
            }
        }
    }

    /**
     * Edit products quantity in cart
     * 
     */
    private function editProduct(): void {

        if (Valid::inPostJson('quantity_product_id') && isset($_SESSION['cart'])) {
            $count = 0;
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] == Valid::inPostJson('quantity_product_id') && Valid::inPostJson('pcs_product') != 'true') {
                    $_SESSION['cart'][$count]['quantity'] = Valid::inPostJson('pcs_product');
                }
                $count++;
            }
        }
    }

    /**
     * Product removing from cart
     * 
     */
    private function deleteProduct(): void {

        if (Valid::inPostJson('delete_product') && isset($_SESSION['cart'])) {
            $array = [];
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] != Valid::inPostJson('delete_product')) {
                    array_push($array, $value);
                }
            }
            $_SESSION['cart'] = $array;
        }
    }

    /**
     * Json Echo Shipping
     *
     */
    private function jsonEchoShipping(): void {

        if (Valid::inPostJson('shipping_region_json')) {
            $shipping = new Shipping();
            $shipping->loadData(Valid::inPostJson('shipping_region_json'));

            $DataBuffer = new DataBuffer();
            $modules_data = $DataBuffer->load('shipping');

            $interface_data = [];
            if (is_array($modules_data)) {
                foreach ($modules_data as $data) {

                    $order_to_pay = (float) $data['chanel_total_price_with_shipping'] + (float) $data['chanel_total_tax'];
                    // INTERFACE
                    $interface = [
                        'chanel_id' => $data['chanel_id'],
                        'chanel_module_name' => $data['chanel_module_name'],
                        'chanel_name' => $data['chanel_name'],
                        'chanel_total_price' => $data['chanel_total_price'],
                        'chanel_total_price_format' => $data['chanel_total_price_format'],
                        'chanel_minimum_price' => $data['chanel_minimum_price'],
                        'chanel_minimum_price_format' => $data['chanel_minimum_price_format'],
                        'chanel_shipping_price' => $data['chanel_shipping_price'],
                        'chanel_shipping_price_format' => $data['chanel_shipping_price_format'],
                        'chanel_total_price_with_shipping' => $data['chanel_total_price_with_shipping'],
                        'chanel_total_price_with_shipping_format' => $data['chanel_total_price_with_shipping_format'],
                        'chanel_total_tax' => $data['chanel_total_tax'],
                        'chanel_total_tax_format' => $data['chanel_total_tax_format'],
                        'chanel_image' => $data['chanel_image'],
                        'chanel_order_to_pay' => $order_to_pay,
                        'chanel_order_to_pay_format' => Ecb::formatPrice($order_to_pay, 1),
                        'chanel_hash' => Cryptography::passwordHash((float) $data['chanel_total_tax'] . $order_to_pay . (float) $data['chanel_total_price_with_shipping'] . Valid::inPostJson('products_order_json') . $data['chanel_module_name'] . (float) $data['chanel_shipping_price'] . (float) $data['chanel_total_price'])
                    ];

                    array_push($interface_data, $interface);
                }
            }
            echo json_encode($interface_data);
            exit;
        }
    }

    /**
     * Json Echo Payment
     *
     */
    private function jsonEchoPayment(): void {
        if (Valid::inPostJson('payment_shipping_json')) {
            $payment = new Payment();
            $payment->loadData(Valid::inPostJson('payment_shipping_json'));

            $DataBuffer = new DataBuffer();
            $modules_data = $DataBuffer->load('payment');

            $interface_data = [];
            if (is_array($modules_data)) {
                foreach ($modules_data as $data) {

                    // INTERFACE
                    $interface = [
                        'chanel_module_name' => $data['chanel_module_name'],
                        'chanel_name' => $data['chanel_name'],
                        'chanel_payment_price' => $data['chanel_payment_price'],
                        'chanel_payment_currency' => $data['chanel_payment_currency'],
                        'chanel_callback_url' => $data['chanel_callback_url'],
                        'chanel_callback_type' => $data['chanel_callback_type'],
                        'chanel_callback_data' => $data['chanel_callback_data'],
                        'chanel_image' => $data['chanel_image']
                    ];

                    array_push($interface_data, $interface);
                }
            }
            echo json_encode($interface_data);
            exit;
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        $output = [];
        if (isset($_SESSION['cart'])) {
            $x = 0;
            foreach ($_SESSION['cart'] as $value) {
                $product = Pdo::getAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value['id']]);
                if ($product != FALSE) {
                    array_push($output, $product[0]);
                } else {
                    unset($_SESSION['cart'][$x]);
                }
                $x++;
            }
        }
        self::$cart_info = $output;
    }

    /**
     * Modal
     *
     */
    private function modal(): void {
        self::$address_data = [];

        if (isset($_SESSION['customer_email']) || isset($_SESSION['without_registration_data'])) {

            if (isset($_SESSION['without_registration_data'])) {
                self::$address_data_json = $_SESSION['without_registration_data'];
            } else {
                self::$address_data_json = Pdo::getValue("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['customer_email']]);
            }

            if (self::$address_data_json != FALSE) {
                self::$address_data = json_decode(self::$address_data_json, true);
            }

            $x = 0;
            foreach (self::$address_data as $address_val) {
                $countries_array = Pdo::getAssoc("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['countries_id']])[0];
                $regions_array = Pdo::getAssoc("SELECT id, name FROM " . TABLE_REGIONS . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['regions_id']])[0];
                if ($address_val['countries_id'] == $countries_array['id']) {
                    self::$address_data[$x]['countries_name'] = $countries_array['name'];
                    self::$address_data[$x]['regions_name'] = $regions_array['name'];
                    if ($address_val['default'] == 1) {
                        self::$address_data[$x]['selected'] = 'selected ';
                    } else {
                        self::$address_data[$x]['selected'] = '';
                    }
                }

                $x++;
            }
        }
        if (isset($_SESSION['cart'])) {
            self::$products_order = json_encode($_SESSION['cart']);
        } else {
            self::$products_order = '';
        }
    }

    /**
     * Counting total quantity product in cart
     *
     * @return int Quantity product
     */
    public static function totalQuantity(): int {

        if (self::$total_quantity == FALSE) {
            self::$total_quantity = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $value) {
                    self::$total_quantity = self::$total_quantity + $value['quantity'];
                }
            }
        }
        return self::$total_quantity;
    }

    /**
     * Counting product price in cart
     *
     * @return float Quantity product
     */
    public static function totalPrice(): float {

        $total_price = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $product = Pdo::getAssoc("SELECT price, currency FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [
                            $value['id'], lang('#lang_all')[0]])[0];

                $total_price = $total_price + Ecb::currencyPrice($product['price'], $product['currency']) * $value['quantity'];
            }
        }
        return $total_price;
    }

    /**
     * Counting quantity product in cart
     * @param int $id Product id
     * @return int Quantity
     */
    public static function productQuantity(int|string $id): int {

        $output = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] == $id) {
                    $output = $value['quantity'];
                }
            }
        }
        return (int) $output;
    }

    /**
     * Max. quantity for order
     * 
     * @param array $product_data Product data
     * @param string|null $flag Flag
     * @return mixed Max. quantity
     */
    public static function maxQuantityToOrder(array $product_data, ?string $flag = null): mixed {
        $quantity = $product_data['quantity'];
        $cart_quantity = self::productQuantity($product_data['id']);
        $total = $quantity - $cart_quantity;

        if ($total == 0 && $flag == 'class') {
            return ' disabled';
        }
        if ($total > 0 && $flag == 'class') {
            return '';
        }

        if ($total == 0) {
            return 0;
        }
        if ($total > 0 && $flag == 'true') {
            return $total;
        }

        if ($total > 0) {
            return 1;
        } else {
            return false;
        }
    }

}
