<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * eMarket Calculated Block
 *
 * @package Ecb
 * @author eMarket
 * 
 */
final class Ecb {

    private static $currencies = FALSE;
    private static $terminal_data = FALSE;
    private static $active_modules = FALSE;

    /**
     * Отображение цены / View price
     * 
     * @param array $input (массив с данными товара / array with products data)
     * @param string $marker (маркер формата валюты / format currency marker)
     * @param string $quantity (количество / quantity)
     * @param string $class (класс bootstrap для скидки / bootstrap class for sale)
     * @return string (выходные данные / output data)
     */
    public static function priceInterface($input, $marker, $quantity = 1, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }

        $INTERFACE = new \eMarket\Interfaces();

        self::discountHandler($input);
        $discounts_data = $INTERFACE->load('discountHandler', 'data', 'discounts_data');
        $discounted_price = $INTERFACE->load('discountHandler', 'data', 'out_price');

        $count = 0;
        $discount_names = '';
        foreach ($discounts_data as $discount) {
            if ($discount['names'] != 'false') {
                $count = $count + count($discount['names']);

                foreach ($discount['names'] as $name_val) {
                    $discount_names .= $name_val . '<br>';
                }
            }
        }

        $input_price = self::currencyPrice($input['price'], $input['currency']);

        if (\eMarket\Settings::path() == 'admin') {
            if ($discounts_data != [] && $input_price != $discounted_price && $count == 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . $discount_names . '" class="label label-' . $class . '">' . self::formatPrice($discounted_price, $marker) . '</span> <del>' . self::formatPrice($input_price, $marker) . '</del>';
            }
            if ($discounts_data != [] && $input_price != $discounted_price && $count > 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . lang('modules_discount_sale_admin_tooltip_warning') . $discount_names . '" class="label label-warning"><u>' . self::formatPrice($discounted_price, $marker) . '</u></span> <del>' . self::formatPrice($input_price, $marker) . '</del>';
            }
            return self::formatPrice($input_price, $marker);
        }

        if (\eMarket\Settings::path() == 'catalog') {
            if ($discounts_data != [] && $input_price != $discounted_price) {
                return '<del>' . self::formatPrice($input_price * $quantity, $marker) . '</del><br><span class="label label-' . $class . '">' . self::formatPrice($discounted_price * $quantity, $marker) . '</span>';
            }
            return self::formatPrice($input_price * $quantity, $marker);
        }
    }

    /**
     * Итого в корзине / Total in cart
     * 
     * @param string $marker ($marker (маркер формата валюты / format currency marker))
     * @param string $class (класс bootstrap для скидки / bootstrap class for sale)
     * @return string (выходные данные / output data)
     */
    public static function totalPriceCartInterface($marker, $class = null) {
        
        $INTERFACE = new \eMarket\Interfaces();
        self::priceTerminal();
        $total_terminal_price = $INTERFACE->load('priceTerminal', 'data', 'discounted_price');
        
        $total_price = \eMarket\Cart::totalPrice();

        if ($class == null) {
            $class = 'danger';
        }

        if ($total_price != $total_terminal_price) {
            return '<del>' . self::formatPrice($total_price, $marker) . '</del><br><span class="label label-' . $class . '">' . self::formatPrice($total_terminal_price, $marker) . '</span>';
        }
        return self::formatPrice($total_price, $marker);
    }

    /**
     * Ценовой терминал / Price terminal
     * 
     * @param string $language (язык / language)
     * @return array (выходные данные / output data)
     */
    public static function priceTerminal($language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }

        $discounted_total_price = 0;
        $total_price_with_tax = 0;
        $price_terminal_data = [];

        $INTERFACE = new \eMarket\Interfaces();

        $taxes_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_TAXES . " WHERE language=?", [$language]);

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$value['id'], $language])[0];
                if ($data != FALSE) {

                    self::discountHandler($data, $language);
                    $discounted_price = $INTERFACE->load('discountHandler', 'data', 'out_price');

                    $tax = [];
                    foreach ($taxes_data as $tax_data) {
                        if ($tax_data['id'] == $data['tax']) {
                            $tax = $tax_data;
                        }
                    }

                    $discounted_total_price = $discounted_total_price + self::currencyPrice($discounted_price, $data['currency']) * $value['quantity'];
                    $total_price_with_tax = $total_price_with_tax + self::totalTax($tax, self::currencyPrice($discounted_price, $data['currency']) * $value['quantity']);

                    $out_data = [
                        'id' => $value['id'],
                        'price' => $data['price'],
                        'currency' => $data['currency'],
                        'price_with_currency' => self::currencyPrice($data['price'], $data['currency']),
                        'quantity' => $value['quantity'],
                        'discount' => $INTERFACE->load('discountHandler', 'data', 'total_discount'),
                        'tax' => $tax
                    ];

                    array_push($price_terminal_data, $out_data);
                }
            }
        }
        $price_terminal_data['discounted_price'] = $discounted_total_price;
        $price_terminal_data['total_tax_price'] = $total_price_with_tax;
        
        $INTERFACE->save('priceTerminal', 'data', $price_terminal_data);
    }

    /**
     * Итоговый налог / Total tax
     * 
     * @param array $tax_data (массив с данными по налогу / array with tax data)
     * @param string $discounted_price (цена с учетом скидок / price with sales)
     * @param string $currency (валюта / currency)
     * @return string (итоговый налог / total tax)
     */
    public static function totalTax($tax_data, $discounted_price) {

        if ($tax_data['fixed'] == '1') {
            $tax_out = $discounted_price / 100 * $tax_data['rate'];
        } else {
            $tax_out = $tax_data['rate'];
        }

        if ($tax_data['tax_type'] == '1') {
            return 0;
        } else {
            return $tax_out;
        }
    }

    /**
     * Обработчик скидок / Discount handler
     * 
     * @param array $input (массив с данными по товару / array with product data)
     * @param string $language (язык /language)
     * @return array (выходные данные / output data)
     */
    public static function discountHandler($input, $language = null) {
        
        if (self::$active_modules == FALSE) {
            self::$active_modules = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['discount', '1']);
        }

        $input_price = \eMarket\Ecb::currencyPrice($input['price'], $input['currency']);

        $discounts_data = [];
        $INTERFACE = new \eMarket\Interfaces();

        $total_discount = 0;
        
        foreach (self::$active_modules as $module) {
            $namespace = '\eMarket\Modules\Discount\\' . ucfirst($module['name']);
            $namespace::dataInterface($input, $language);
            array_push($discounts_data, $INTERFACE->load('discount', $module['name']));
        }

        foreach ($discounts_data as $value) {
            if ($value['discounts'] != 'false') {
                foreach ($value['discounts'] as $val) {
                    $total_discount = $total_discount + $val;
                }
            }
        }
        
        $discounted_price = $input['price'] / 100 * (100 - $total_discount);

        if ($discounted_price != 0 && $discounted_price != $input_price) {

            $out_data = [
                'out_price' => $discounted_price,
                'total_discount' => $total_discount,
                'discounts_data' => $discounts_data
            ];

            $INTERFACE->save('discountHandler', 'data', $out_data);
        } else {
            $out_data = [
                'out_price' => $input_price,
                'total_discount' => $total_discount,
                'discounts_data' => $discounts_data
            ];

            $INTERFACE->save('discountHandler', 'data', $out_data);
        }
    }

    /**
     * Стоимость с учетом валюты / Price with currency
     *
     * @param string $price (значение стоимости / price value)
     * @param string $currency (id валюты / currency id)
     * @return string|FALSE string (стоимость с учетом валюты / price with currency)
     */
    public static function currencyPrice($price, $currency) {

        $currencies = \eMarket\Settings::currenciesData();

        foreach ($currencies as $value) {
            if ($value['id'] == $currency) {
                return $price / $value['value'];
            }
        }
        return FALSE;
    }

    /**
     * Стоимость с учетом регионального формата / Price with region format
     *
     * @param string $price (цена / price)
     * @param string $format (флаг формата / format flag)
     * @param string $language (язык / language)
     * @return array $price (данные по стоимости / price data)
     */
    public static function formatPrice($price, $format = null, $language = null) {

        if ($language == null) {
            $CURRENCIES = \eMarket\Settings::currencyDefault();
        } else {
            $CURRENCIES = \eMarket\Settings::currencyDefault($language);
        }

        if ($format == 0) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[1] . ' ' . number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language)) . ' ' . $CURRENCIES[1];
            }
        }

        if ($format == 1) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[2] . ' ' . number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language)) . ' ' . $CURRENCIES[2];
            }
        }

        if ($format == 2) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[7] . ' ' . number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language)) . ' ' . $CURRENCIES[7];
            }
        }

        if ($format == 3) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[3] . ' ' . number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language)) . ' ' . $CURRENCIES[3];
            }
        }

        return number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
    }

}

?>