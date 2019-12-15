<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

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
     * @param array $input_product_sales (данные о скидках на товары)
     * @return array $output_price (итоговая стоимость в корзине)
     */
    public static function init($cart, $CURRENCIES, $input_product_sales) {
        $input_price = self::inputPrice($cart, $CURRENCIES);
        return $product_sale_block = self::productSaleBlock($input_price, $input_product_sales);
        //$total_sale_block = self::totalSaleBlock($product_sale_block);
        //$shipping_block = self::totalSaleBlock($total_sale_block);
        //$checkout_block = self::totalSaleBlock($shipping_block);
        //$output_price = self::outputPrice($checkout_block);
        //return $output_price;
    }

    /**
     * Блок формирования входящей стоимости
     * @param array $cart (данные из корзины)
     * @param string $CURRENCIES (валюта)
     * @return array $cart_data (выходные данные)
     */
    private static function inputPrice($cart, $CURRENCIES) {

        $cart_data = [];
        foreach ($cart as $value) {
            $products = \eMarket\Products::productData($value['id'])[0];
            $value = array_merge($value, ['price' => $products['price']], ['currencies' => $CURRENCIES[0]]);
            array_push($cart_data, $value);
        }
        return $cart_data;
    }

    /**
     * Блок формирования скидки на товар
     * @param array $cart_data (данные из inputPrice)
     * @param array $input_product_sales (данные о скидках на товары)
     * @return array $output (выходные данные)
     */
    private static function productSaleBlock($cart_data, $input_product_sales) {
        $x = 0;
        foreach ($cart_data as $cart) {
            foreach ($input_product_sales as $sale) {
                if ($cart['id'] == $sale['product_id']) {
                    $cart_data[$x] = array_merge($cart_data[$x], ['productSale_' . $sale['id'] => $sale['sale']]);
                }
            }
            $x++;
        }
        return $cart_data;
    }
    
    /**
     * Блок вывода цены с учетом скидки
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $CURRENCIES (валюта)
     * @param string $marker (маркер для \eMarket\Products::productPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function priceInterface($input, $CURRENCIES, $marker, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }
        //Модуль скидки \eMarket\Modules\Discount\Sale
        $price_with_sale = \eMarket\Modules\Discount\Sale::dataInterface($input);

        if (\eMarket\Set::path() == 'admin') {
            $price_val = $input[5];

            if ($price_val != $price_with_sale[0] && $price_with_sale[2] == 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . $price_with_sale[1] . '" class="label label-' . $class . '">' . \eMarket\Products::productPrice($price_with_sale[0], $CURRENCIES, $marker) . '</span> <del>' . \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '</del>';
            }
            if ($price_val != $price_with_sale[0] && $price_with_sale[2] > 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . lang('modules_discount_sale_admin_tooltip_warning') . $price_with_sale[1] . '" class="label label-warning"><u>' . \eMarket\Products::productPrice($price_with_sale[0], $CURRENCIES, $marker) . '</u></span> <del>' . \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '</del>';
            }
            return \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker);
        }

        if (\eMarket\Set::path() == 'catalog') {
            $price_val = $input['price'];

            if ($price_val != $price_with_sale[0]) {
                return '<del>' . \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Products::productPrice($price_with_sale[0], $CURRENCIES, $marker) . '</span>';
            }
            return \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '<br><br>';
        }
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