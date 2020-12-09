<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Движок ECB (Easy Calculated Block) v.1.01
 *
 * @package Ecb
 * @author eMarket
 * 
 */
final class Ecb {

    public static $stiker_data = FALSE;

    /**
     * Блок вывода цены с учетом скидки
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $marker (маркер для \eMarket\Products::productPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function priceInterface($input, $marker, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }

        $price_with_sale = self::outPrice($input);

        if (\eMarket\Set::path() == 'admin') {
            $price_val = \eMarket\Products::currencyPrice($input[5], $input[8]);

            if ($price_val != $price_with_sale[0] && $price_with_sale[2] == 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . $price_with_sale[1] . '" class="label label-' . $class . '">' . \eMarket\Products::productPrice($price_with_sale[0], $marker) . '</span> <del>' . \eMarket\Products::productPrice($price_val, $marker) . '</del>';
            }
            if ($price_val != $price_with_sale[0] && $price_with_sale[2] > 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . lang('modules_discount_sale_admin_tooltip_warning') . $price_with_sale[1] . '" class="label label-warning"><u>' . \eMarket\Products::productPrice($price_with_sale[0], $marker) . '</u></span> <del>' . \eMarket\Products::productPrice($price_val, $marker) . '</del>';
            }
            return \eMarket\Products::productPrice($price_val, $marker);
        }

        if (\eMarket\Set::path() == 'catalog') {
            $price_val = \eMarket\Products::currencyPrice($input['price'], $input['currency']);

            if ($price_val != $price_with_sale[0]) {
                return '<del>' . \eMarket\Products::productPrice($price_val, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Products::productPrice($price_with_sale[0], $marker) . '</span>';
            }
            return \eMarket\Products::productPrice($price_val, $marker);
        }
    }
    
        /**
     * Блок вывода итоговой цены товара
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $class (класс bootstrap для отображения стикера скидки)
     * @param string $class2 (класс bootstrap для отображения собственного стикера)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function outPrice($input) {
        //Модуль скидки \eMarket\Modules\Discount\Sale
        $price_with_sale = \eMarket\Modules\Discount\Sale::dataInterface($input);
        
        $output = $price_with_sale;
        return $output;
    }

    /**
     * Блок вывода стикеров
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $class (класс bootstrap для отображения стикера скидки)
     * @param string $class2 (класс bootstrap для отображения собственного стикера)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function stikers($input, $class = null, $class2 = null) {

        if ($class == null) {
            $class = 'danger';
        }
        if ($class2 == null) {
            $class2 = 'success';
        }
        if (self::$stiker_data == false) {
            self::$stiker_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [lang('#lang_all')[0]]);
        }
        $stiker_name = [];
        foreach (self::$stiker_data as $val) {
            $stiker_name[$val['id']] = $val['name'];
        }

        $price_with_sale = self::outPrice($input);

        if (isset($price_with_sale[3]) && $price_with_sale[3] > 0 && $input['stiker'] != '' && $input['stiker'] != NULL) {
            return '<div class="labelsblock"><div class="' . $class . '">- ' . $price_with_sale[3] . '%</div><div class="' . $class2 . '">' . $stiker_name[$input['stiker']] . '</div></div>';
        }

        if ($input['stiker'] != '' && $input['stiker'] != NULL) {
            return '<div class="labelsblock"><div class="' . $class2 . '">' . $stiker_name[$input['stiker']] . '</div></div>';
        }

        if (isset($price_with_sale[3]) && $price_with_sale[3] > 0) {
            return '<div class="labelsblock"><div class="' . $class . '">- ' . $price_with_sale[3] . '%</div></div>';
        }
        return '';
    }

    /**
     * Блок вывода цены в корзине с учетом скидки
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $marker (маркер для \eMarket\Products::productPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function priceCartInterface($input, $marker, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }
        $price_with_sale = self::outPrice($input);

        $price_val = \eMarket\Products::currencyPrice($input['price'], $input['currency']);

        if ($price_val != $price_with_sale[0]) {
            return '<del>' . \eMarket\Products::productPrice($price_val * \eMarket\Cart::productQuantity($input['id'], 1), $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Products::productPrice($price_with_sale[0] * \eMarket\Cart::productQuantity($input['id'], 1), $marker) . '</span>';
        }
        return \eMarket\Products::productPrice($price_val * \eMarket\Cart::productQuantity($input['id'], 1), $marker);
    }

    /**
     * Данные цены в корзине с учетом скидки
     * 
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function totalPriceCartWithSale() {

        $total_price_with_sale = 0;
        if (isset($_SESSION['cart'])) {
            $x = 0;
            foreach ($_SESSION['cart'] as $value) {
                $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$value['id'], lang('#lang_all')[0]]);
                if ($data != FALSE) {
                    $sale = self::outPrice($data[0]);
                    if (array_key_exists(3, $sale)) {
                        $total_price_with_sale = $total_price_with_sale + (\eMarket\Products::currencyPrice($data[0]['price'], $data[0]['currency']) * $value['quantity'] / 100 * (100 - $sale[3]));
                    } else {
                        $total_price_with_sale = $total_price_with_sale + (\eMarket\Products::currencyPrice($data[0]['price'], $data[0]['currency']) * $value['quantity']);
                    }
                } else {
                    unset($_SESSION['cart'][$x]);
                }
                $x++;
            }
        }
        return $total_price_with_sale;
    }

    /**
     * Блок вывода цены в корзине с учетом скидки
     * 
     * @param string $marker (маркер для \eMarket\Products::productPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function totalPriceCartInterface($marker, $class = null) {

        $total_price_with_sale = self::totalPriceCartWithSale();
        $price_val = \eMarket\Cart::totalPrice();

        if ($class == null) {
            $class = 'danger';
        }

        if ($price_val != $total_price_with_sale) {
            return '<del>' . \eMarket\Products::productPrice($price_val, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Products::productPrice($total_price_with_sale, $marker) . '</span>';
        }
        return \eMarket\Products::productPrice($price_val, $marker);
    }

}

?>