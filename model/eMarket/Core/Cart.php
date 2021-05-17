<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use \eMarket\Core\{
    Ecb,
    Func,
    Pdo,
    Settings,
    Valid
};

/**
 * Class for working with a cart
 *
 * @package Cart
 * @author eMarket
 * 
 */
class Cart {

    /**
     * Add product to cart
     */
    public static function addProduct() {

        if (Valid::inGET('add_to_cart')) {
            $id = Valid::inGET('add_to_cart');

            if (!Valid::inGET('add_quantity')) {
                $quantity = 1;
            } else {
                $quantity = Valid::inGET('add_quantity');
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
     * Counting total quantity product in cart
     *
     * @return string Quantity product
     */
    public static function totalQuantity() {

        $total_quantity = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $total_quantity = $total_quantity + $value['quantity'];
            }
        }
        return $total_quantity;
    }

    /**
     * Counting product price in cart
     *
     * @return string Quantity product
     */
    public static function totalPrice() {

        $total_price = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $product = Pdo::getColAssoc("SELECT price, currency FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [
                            $value['id'], lang('#lang_all')[0]])[0];

                $total_price = $total_price + Ecb::currencyPrice($product['price'], $product['currency']) * $value['quantity'];
            }
        }
        return $total_price;
    }

    /**
     * Init cart
     *
     */
    public static function init() {

        if (Settings::path() == 'catalog') {
            self::addProduct();
            self::deleteProduct();
            self::editProductQuantity();
        }
    }

    /**
     * Products info in cart
     *
     * @return array Output data
     */
    public static function info() {

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
        return $output;
    }

    /**
     * Counting quantity product in cart
     * @param string $id Product id
     * @return string Quantity
     */
    public static function productQuantity($id) {

        $output = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] == $id) {
                    $output = $value['quantity'];
                }
            }
        }
        return $output;
    }

    /**
     * Product removing from cart
     * 
     */
    public static function deleteProduct() {

        if (Valid::inGET('delete_product') && isset($_SESSION['cart'])) {
            $array = [];
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] != Valid::inGET('delete_product')) {
                    array_push($array, $value);
                }
            }
            $_SESSION['cart'] = $array;
        }
    }

    /**
     * Max. quantity for order
     * 
     * @param array $product_data Product data
     * @param string $flag Flag
     * @return int|false
     */
    public static function maxQuantityToOrder($product_data, $flag = null) {
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

    /**
     * Edit products quantity in cart
     * 
     */
    public static function editProductQuantity() {

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

}
