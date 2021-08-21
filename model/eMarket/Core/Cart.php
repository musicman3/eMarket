<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Ecb,
    Pdo
};

/**
 * Class for working with a cart
 *
 * @package Cart
 * @author eMarket
 * 
 */
class Cart {

    public static $total_quantity = FALSE;

    /**
     * Counting total quantity product in cart
     *
     * @return string Quantity product
     */
    public static function totalQuantity() {

        if (self::$total_quantity == FALSE) {
            self::$total_quantity = 0;
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $value) {
                    self::$total_quantity = self::$total_quantity + $value['quantity'];
                }
            }
            return self::$total_quantity;
        } else {
            return self::$total_quantity;
        }
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

}
