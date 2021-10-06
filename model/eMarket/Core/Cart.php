<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Ecb,
    Pdo
};

/**
 * Class for working with a cart
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Cart {

    public static $total_quantity = FALSE;

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
