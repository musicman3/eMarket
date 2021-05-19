<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use \eMarket\Core\{
    Autorize,
    Ecb,
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
        $this->jsonEchoShipping();
        $this->jsonEchoPayment();
        $this->data();
        $this->modal();
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
        self::$cart_info = \eMarket\Core\Cart::info();
    }

    /**
     * Modal
     *
     */
    public function modal() {
        self::$address_data = [];
        if (isset($_SESSION['email_customer'])) {
            self::$address_data_json = Pdo::getCellFalse("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);

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
