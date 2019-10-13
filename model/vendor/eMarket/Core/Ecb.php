<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Движок ECB (Easy Calculated Block) v.1.0
 *
 * @package Ecb
 * @author eMarket
 * 
 */
final class Ecb {

    /**
     * Инициализация ECB
     * @param array $cart (данные из корзины)
     * @param string $CURRENCIES (валюта)
     * @return array $output_price (итоговая стоимость в корзине)
     */
    public static function init($cart, $CURRENCIES) {
        return $input_price = self::inputPrice($cart, $CURRENCIES);
        $product_sale_block = self::productSaleBlock($input_price);
        $total_sale_block = self::totalSaleBlock($product_sale_block);
        $shipping_block = self::totalSaleBlock($total_sale_block);
        $checkout_block = self::totalSaleBlock($shipping_block);
        $output_price = self::outputPrice($checkout_block);
        //return $output_price;
    }

    /**
     * Блок формирования входящей стоимости
     * @param array $cart (данные из корзины)
     * @param string $CURRENCIES (валюта)
     * @return array $output (выходные данные)
     */
    private static function inputPrice($cart, $CURRENCIES) {
        
        $new_array = [];
        foreach ($cart as $value) {
            $products = \eMarket\Other\Products::productData($value['id'])[0];
            $value = array_merge($value, ['price' => $products['price']], ['currencies' => $CURRENCIES[0]]);
            array_push($new_array, $value);
        }
        return $new_array;
    }

    /**
     * Блок формирования скидки на товар
     * @param array $input (данные из inputPrice)
     * @return array $output (выходные данные)
     */
    private static function productSaleBlock($input) {
        //echo ($output);
    }

    /**
     * Блок формирования итоговой скидки на заказ
     * @param array $input (данные из productSaleBlock)
     * @return array $output (выходные данные)
     */
    private static function totalSaleBlock($input) {
        //echo ($output);
    }

    /**
     * Блок формирования стоимости доставки
     * @param array $input (данные из totalSaleBlock)
     * @return array $output (выходные данные)
     */
    private static function shippingBlock($input) {
        //echo ($output);
    }

    /**
     * Блок формирования оплаты
     * @param array $input (данные из shippingBlock)
     * @return array $output (выходные данные)
     */
    private static function checkoutBlock($input) {
        //echo ($output);
    }

    /**
     * Блок формирования исходящей стоимости
     * @param array $input (данные из checkoutBlock)
     * @return array $output (выходные данные)
     */
    private static function outputPrice($input) {
        //echo ($output);
    }

}

?>