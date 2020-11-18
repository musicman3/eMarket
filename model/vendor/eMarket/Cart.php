<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для работы с корзиной
 *
 * @package Cart
 * @author eMarket
 * 
 */
class Cart {

    /**
     * Добавление товара в корзину
     */
    public static function addProduct() {

        if (\eMarket\Valid::inGET('add_to_cart')) {
            $id = \eMarket\Valid::inGET('add_to_cart');

            if (!\eMarket\Valid::inGET('add_quantity')) {
                $quantity = 1;
            } else {
                $quantity = \eMarket\Valid::inGET('add_quantity');
            }

            $count = 0;
            if (!isset($_SESSION['cart']) OR count($_SESSION['cart']) == 0) {
                $_SESSION['cart'] = [['id' => $id, 'quantity' => $quantity]];
            } else {
                // Если не было такого id, то добавляем в массив для подсчета
                $id_count = \eMarket\Func::filterArrayToKey($_SESSION['cart'], 'id', $id, 'id');
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
     * Подсчет количества товара в корзине
     *
     * @return string $total_quantity (количества товара)
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
     * Подсчет стоимости в корзине
     *
     * @return string $total_price (количества товара)
     */
    public static function totalPrice() {

        $total_price = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $price = \eMarket\Pdo::getCell("SELECT price FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$value['id'], lang('#lang_all')[0]]);
                $total_price = $total_price + $price * $value['quantity'];
            }
        }
        return $total_price;
    }

    /**
     * Инициализация корзины на страницы
     *
     */
    public static function init() {

        if (\eMarket\Set::path() == 'catalog') {
            self::addProduct();
            self::deleteProduct();
            self::editProductQuantity();
        }
    }

    /**
     * Информация о товарах в корзине
     *
     * @return array $cart (информация о товарах в корзине)
     */
    public static function info() {

        $cart_info = [];
        if (isset($_SESSION['cart'])) {
            $x = 0;
            foreach ($_SESSION['cart'] as $value) {
                $product = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $value['id']]);
                if ($product != FALSE) {
                    array_push($cart_info, $product[0]);
                } else {
                    unset($_SESSION['cart'][$x]);
                }
                $x++;
            }
        }
        return $cart_info;
    }

    /**
     * Подсчет количества товара в корзине
     * @param string $id (ID товара в корзине)
     * @return string $total_quantity (количество товара)
     */
    public static function productQuantity($id) {

        $product_quantity = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] == $id) {
                    $product_quantity = $value['quantity'];
                }
            }
        }
        return $product_quantity;
    }

    /**
     * Удаляем товар из корзины
     * 
     */
    public static function deleteProduct() {

        if (\eMarket\Valid::inGET('delete_product') && isset($_SESSION['cart'])) {
            $array_new = [];
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] != \eMarket\Valid::inGET('delete_product')) {
                    array_push($array_new, $value);
                }
            }
            $_SESSION['cart'] = $array_new;
        }
    }

    /**
     * Максимальное количество для заказа
     * 
     * @param array $product_data (Данные о товаре)
     * @return int|false
     */
    public static function maxQuantityToOrder($product_data, $flag = null) {
        $quantity = $product_data['quantity'];
        $cart_quantity = \eMarket\Cart::productQuantity($product_data['id']);
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
     * Редактирование количества товара в корзине
     * 
     */
    public static function editProductQuantity() {

        if (\eMarket\Valid::inGET('quantity_product_id') && isset($_SESSION['cart'])) {
            $count = 0;
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] == \eMarket\Valid::inGET('quantity_product_id') && \eMarket\Valid::inGET('pcs_product') != 'true') {
                    $_SESSION['cart'][$count]['quantity'] = \eMarket\Valid::inGET('pcs_product');
                }
                $count++;
            }
        }
    }

}

?>