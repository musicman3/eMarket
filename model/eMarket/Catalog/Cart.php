<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use eMarket\Core\{
    Autorize,
    Ecb,
    Func,
    Interfaces,
    Payment,
    Pdo,
    Shipping,
    Valid
};

/**
 * Cart
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class Cart {

    public static $cart_info = FALSE;
    public static $address_data = FALSE;
    public static $products_order = FALSE;
    public static $address_data_json = FALSE;

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
    public function addProduct() {

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
            if (!isset($_SESSION['cart']) OR count($_SESSION['cart']) == 0) {
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
    public function editProduct() {

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
    public function deleteProduct() {

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
    public function jsonEchoShipping() {

        if (Valid::inPostJson('shipping_region_json')) {
            $zones_id = Shipping::shippingZonesAvailable(Valid::inPostJson('shipping_region_json'));
            Shipping::loadData($zones_id);

            $INTERFACE = new Interfaces();
            $modules_data = $INTERFACE->load('shipping');

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
                        'chanel_hash' => Autorize::passwordHash((float) $data['chanel_total_tax'] . $order_to_pay . (float) $data['chanel_total_price_with_shipping'] . Valid::inPostJson('products_order_json') . $data['chanel_module_name'] . (float) $data['chanel_shipping_price'] . (float) $data['chanel_total_price'])
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
    public function jsonEchoPayment() {
        if (Valid::inPostJson('payment_shipping_json')) {
            Payment::loadData(Valid::inPostJson('payment_shipping_json'));

            $INTERFACE = new Interfaces();
            $modules_data = $INTERFACE->load('payment');

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
    public function data() {
        $output = [];
        if (isset($_SESSION['cart'])) {
            $x = 0;
            foreach ($_SESSION['cart'] as $value) {
                $product = Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value['id']]);
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
    public function modal() {
        self::$address_data = [];
        if (isset($_SESSION['email_customer'])) {
            self::$address_data_json = Pdo::getCell("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);

            if (self::$address_data_json != FALSE) {
                self::$address_data = json_decode(self::$address_data_json, 1);
            }

            $x = 0;
            foreach (self::$address_data as $address_val) {
                $countries_array = Pdo::getColAssoc("SELECT id, name FROM " . TABLE_COUNTRIES . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['countries_id']])[0];
                $regions_array = Pdo::getColAssoc("SELECT id, name FROM " . TABLE_REGIONS . " WHERE language=? AND id=? ORDER BY name ASC", [lang('#lang_all')[0], $address_val['regions_id']])[0];
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

}
