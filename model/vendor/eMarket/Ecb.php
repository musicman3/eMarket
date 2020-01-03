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
     * Блок вывода цены в корзине с учетом скидки
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $CURRENCIES (валюта)
     * @param string $marker (маркер для \eMarket\Products::productPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function priceCartInterface($input, $CURRENCIES, $marker, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }
        //Модуль скидки \eMarket\Modules\Discount\Sale
        $price_with_sale = \eMarket\Modules\Discount\Sale::dataInterface($input);

        $price_val = $input['price'];

        if ($price_val != $price_with_sale[0]) {
            return '<del>' . \eMarket\Products::productPrice($price_val * \eMarket\Cart::productQuantity($input['id'], $CURRENCIES, 1), $CURRENCIES, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Products::productPrice($price_with_sale[0] * \eMarket\Cart::productQuantity($input['id'], $CURRENCIES, 1), $CURRENCIES, $marker) . '</span>';
        }
        return \eMarket\Products::productPrice($price_val * \eMarket\Cart::productQuantity($input['id'], $CURRENCIES, 1), $CURRENCIES, $marker) . '<br><br>';
    }

    /**
     * Блок вывода цены в корзине с учетом скидки
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $CURRENCIES (валюта)
     * @param string $marker (маркер для \eMarket\Products::productPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function totalPriceCartInterface($CURRENCIES, $marker, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }

        $total_price_with_sale = 0;
        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$value['id'], lang('#lang_all')[0]])[0];
                //Модуль скидки \eMarket\Modules\Discount\Sale
                $sale = \eMarket\Modules\Discount\Sale::dataInterface($data);
                if (array_key_exists(3, $sale)) {
                    $total_price_with_sale = $total_price_with_sale + ($data['price'] * $value['quantity'] / 100 * (100 - $sale[3]));
                } else {
                    $total_price_with_sale = $total_price_with_sale + ($data['price'] * $value['quantity']);
                }
            }
        }


        $price_val = \eMarket\Cart::totalPrice();

        if ($price_val != $total_price_with_sale) {
            return '<del>' . \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Products::productPrice($total_price_with_sale, $CURRENCIES, $marker) . '</span>';
        }
        return \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '<br><br>';
    }

    /**
     * Блок формирования стоимости доставки
     * @param array $input (данные из totalSaleBlock)
     * @return array $output (выходные данные)
     */
    public static function shippingBlock() {
        $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE install=? AND active=? AND type=?", [1, 1, 'shipping']);

        $modules_data = []; // Данные по всем модулям доставки (инсталлированным и активным)
        foreach ($data as $module) {
            $mod_array = \eMarket\Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_' . $module['name'], []);
            array_push($modules_data, $mod_array);
        }

        $address_data_json = \eMarket\Pdo::getCellFalse("SELECT address_book FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']]);

        if ($address_data_json == FALSE) {
            $address_data = [];
        } else {
            $address_data = json_decode($address_data_json, 1);
        }
        //return $modules_data[0];
        $array_return = [];
        foreach ($address_data as $val) {
            $data_reg = \eMarket\Pdo::getCellFalse("SELECT zones_id FROM " . TABLE_ZONES_VALUE . " WHERE regions_id=?", [$val['regions_id']]);
         
            if ($data_reg != FALSE) {
                foreach ($modules_data[0] as $mod_data) {
                    if ($mod_data['shipping_zone'] == $data_reg) {
                        array_push($array_return, $data_reg);
                    }
                }
            }
        }
        return $array_return;
    }

    /**
     * Блок формирования оплаты
     * @param array $input (данные из shippingBlock)
     * @return array $output (выходные данные)
     */
    private static function checkoutBlock($input) {
        //echo ($output);
    }

}

?>