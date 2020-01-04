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
            return \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker);
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
        return \eMarket\Products::productPrice($price_val * \eMarket\Cart::productQuantity($input['id'], $CURRENCIES, 1), $CURRENCIES, $marker);
    }

    /**
     * Данные цены в корзине с учетом скидки
     * 
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function totalPriceCartWithSale() {

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
        return $total_price_with_sale;
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

        $total_price_with_sale = self::totalPriceCartWithSale();
        $price_val = \eMarket\Cart::totalPrice();

        if ($class == null) {
            $class = 'danger';
        }

        if ($price_val != $total_price_with_sale) {
            return '<del>' . \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Products::productPrice($total_price_with_sale, $CURRENCIES, $marker) . '</span>';
        }
        return \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker);
    }

    /**
     * Список зон, для которых доступна доставка покупателю
     * @return array $output (выходные данные в виде id зон)
     */
    public static function shippingZonesAvailable($region) {
        $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE install=? AND active=? AND type=?", [1, 1, 'shipping']);

        $modules_data = [];
        foreach ($data as $module) {
            $mod_array = \eMarket\Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_' . $module['name'], []);
            array_push($modules_data, $mod_array);
        }

        $output = [];
        $data_reg = \eMarket\Pdo::getCellFalse("SELECT zones_id FROM " . TABLE_ZONES_VALUE . " WHERE regions_id=?", [$region]);

        if ($data_reg != FALSE) {
            foreach ($modules_data as $mod_data_ext) {
                foreach ($mod_data_ext as $mod_data) {
                    // Если есть минимальная цена для включения модуля
                    if (isset($mod_data['minimum_price'])) {
                        $minimum_price = $mod_data['minimum_price'];
                    } else {
                        $minimum_price = 0;
                    }
                    if ($mod_data['shipping_zone'] == $data_reg && $minimum_price <= self::totalPriceCartWithSale()) {
                        array_push($output, $data_reg);
                    }
                }
            }
        }

        return $output;
    }

    /**
     * Список модулей доставки, для которых доступна доставка покупателю
     * @return array $output (выходные данные в виде id зон)
     */
    public static function shippingModulesAvailable($region) {
        $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE install=? AND active=? AND type=?", [1, 1, 'shipping']);
        $shipping_available = self::shippingZonesAvailable($region);

        $modules_data = [];
        foreach ($data as $module) {
            $mod_array = \eMarket\Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_' . $module['name'], []);
            array_push($modules_data, [$module['name'] => $mod_array]);
        }
        $output = [];

        foreach ($data as $val) {
            foreach ($modules_data as $data_arr) {
                if (isset($data_arr[$val['name']])) {
                    foreach ($data_arr[$val['name']] as $data_name) {
                        if (in_array($data_name['shipping_zone'], $shipping_available)) {
                            if (!in_array($val['name'], $output)) {
                                array_push($output, $val['name']);
                            }
                        }
                    }
                }
            }
        }

        return $output;
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