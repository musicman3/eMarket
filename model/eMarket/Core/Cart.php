<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для работы с корзиной / Class for working with a cart
 *
 * @package Cart
 * @author eMarket
 * 
 */
class Cart {

    /**
     * Добавление товара в корзину / Add product to cart
     */
    public static function addProduct() {

        if (\eMarket\Core\Valid::inGET('add_to_cart')) {
            $id = \eMarket\Core\Valid::inGET('add_to_cart');

            if (!\eMarket\Core\Valid::inGET('add_quantity')) {
                $quantity = 1;
            } else {
                $quantity = \eMarket\Core\Valid::inGET('add_quantity');
            }

            $count = 0;
            if (!isset($_SESSION['cart']) OR count($_SESSION['cart']) == 0) {
                $_SESSION['cart'] = [['id' => $id, 'quantity' => $quantity]];
            } else {

                $id_count = \eMarket\Core\Func::filterArrayToKey($_SESSION['cart'], 'id', $id, 'id');
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
     * Подсчет итогового количества товара в корзине / Counting total quantity product in cart
     *
     * @return string $total_quantity (количества товара / quantity product)
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
     * Подсчет стоимости товара в корзине / Counting product price in cart
     *
     * @return string $total_price (количество товара / quantity product)
     */
    public static function totalPrice() {

        $total_price = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $product = \eMarket\Core\Pdo::getColAssoc("SELECT price, currency FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$value['id'], lang('#lang_all')[0]])[0];
                $total_price = $total_price + \eMarket\Core\Ecb::currencyPrice($product['price'], $product['currency']) * $value['quantity'];
            }
        }
        return $total_price;
    }

    /**
     * Инициализация корзины / Init cart
     *
     */
    public static function init() {

        if (\eMarket\Core\Settings::path() == 'catalog') {
            self::addProduct();
            self::deleteProduct();
            self::editProductQuantity();
        }
    }

    /**
     * Информация о товарах в корзине / Products info in cart
     *
     * @return array $output (исходящие данные / output data)
     */
    public static function info() {

        $output = [];
        if (isset($_SESSION['cart'])) {
            $x = 0;
            foreach ($_SESSION['cart'] as $value) {
                $product = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value['id']]);
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
     * Подсчет количества товара в корзине / Counting quantity product in cart
     * @param string $id (id товара / product id)
     * @return string $output (количество / quantity)
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
     * Удаление товара из корзины / Product removing from cart
     * 
     */
    public static function deleteProduct() {

        if (\eMarket\Core\Valid::inGET('delete_product') && isset($_SESSION['cart'])) {
            $array = [];
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] != \eMarket\Core\Valid::inGET('delete_product')) {
                    array_push($array, $value);
                }
            }
            $_SESSION['cart'] = $array;
        }
    }

    /**
     * Максимальное количество для заказа / Max. quantity for order
     * 
     * @param array $product_data (данные о товаре / product data)
     * @param string $flag (флаг / flag)
     * @return int|false
     */
    public static function maxQuantityToOrder($product_data, $flag = null) {
        $quantity = $product_data['quantity'];
        $cart_quantity = \eMarket\Core\Cart::productQuantity($product_data['id']);
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
     * Редактирование количества товара в корзине / Edit products quantity in cart
     * 
     */
    public static function editProductQuantity() {

        if (\eMarket\Core\Valid::inGET('quantity_product_id') && isset($_SESSION['cart'])) {
            $count = 0;
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] == \eMarket\Core\Valid::inGET('quantity_product_id') && \eMarket\Core\Valid::inGET('pcs_product') != 'true') {
                    $_SESSION['cart'][$count]['quantity'] = \eMarket\Core\Valid::inGET('pcs_product');
                }
                $count++;
            }
        }
    }

}

?>