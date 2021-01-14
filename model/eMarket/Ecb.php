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

        $discount_sales = self::discountHandler($input)['interface'];
        $discount_price = self::discountHandler($input)['out_price'];

        $discount_count = 0;
        $discount_names = '';
        foreach ($discount_sales as $discount_sale) {
            if ($discount_sale['names'] != 'false') {
                $discount_count = $discount_count + count($discount_sale['names']);

                foreach ($discount_sale['names'] as $name_val) {
                    $discount_names .= $name_val . '<br>';
                }
            }
        }

        $price_val = self::currencyPrice($input['price'], $input['currency']);

        if (\eMarket\Settings::path() == 'admin') {
            if ($discount_sales != [] && $price_val != $discount_price && $discount_count == 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . $discount_names . '" class="label label-' . $class . '">' . self::formatPrice($discount_price, $marker) . '</span> <del>' . self::formatPrice($price_val, $marker) . '</del>';
            }
            if ($discount_sales != [] && $price_val != $discount_price && $discount_count > 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . lang('modules_discount_sale_admin_tooltip_warning') . $discount_names . '" class="label label-warning"><u>' . self::formatPrice($discount_price, $marker) . '</u></span> <del>' . self::formatPrice($price_val, $marker) . '</del>';
            }
            return self::formatPrice($price_val, $marker);
        }

        if (\eMarket\Settings::path() == 'catalog') {
            if ($discount_sales != [] && $price_val != $discount_price) {
                return '<del>' . self::formatPrice($price_val * $quantity, $marker) . '</del><br><span class="label label-' . $class . '">' . self::formatPrice($discount_price * $quantity, $marker) . '</span>';
            }
            return self::formatPrice($price_val * $quantity, $marker);
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

        $total_terminal_price = self::priceTerminal();
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
     * @param string $marker (маркер / marker)
     * @param string $language (язык / language)
     * @return array (выходные данные / output data)
     */
    public static function priceTerminal($marker = null, $language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        } else {
            // reset data
            self::$terminal_data = FALSE;
        }

        if (self::$terminal_data != FALSE) {
            if ($marker == 'interface') {
                return self::$terminal_data;
            } elseif ($marker == 'total_tax_price') {
                return self::$terminal_data['total_tax_price'];
            } else {
                return self::$terminal_data['total_price_with_sale'];
            }
        }

        $total_price_with_sale = 0;
        $total_tax_price = 0;
        $interface_data = [];

        $taxes_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_TAXES . " WHERE language=?", [$language]);

        if (isset($_SESSION['cart'])) {
            $x = 0;
            foreach ($_SESSION['cart'] as $value) {
                $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$value['id'], $language])[0];
                if ($data != FALSE) {
                    $discount_sales = self::discountHandler($data, $language)['out_price'];

                    $tax = [];
                    foreach ($taxes_data as $tax_data) {
                        if ($tax_data['id'] == $data['tax']) {
                            $tax = $tax_data;
                        }
                    }

                    $total_price_with_sale = $total_price_with_sale + self::currencyPrice($discount_sales, $data['currency']) * $value['quantity'];
                    $total_tax_price = $total_tax_price + self::totalTax($tax, self::currencyPrice($discount_sales, $data['currency']) * $value['quantity']);

                    $interface = [
                        'id' => $value['id'],
                        'price' => $data['price'],
                        'currency' => $data['currency'],
                        'price_with_currency' => self::currencyPrice($data['price'], $data['currency']),
                        'quantity' => $value['quantity'],
                        'discount' => self::discountHandler($data, $language)['total_discount'],
                        'tax' => $tax
                    ];

                    array_push($interface_data, $interface);
                } else {
                    unset($_SESSION['cart'][$x]);
                }
                $x++;
            }
        }
        $interface_data['total_price_with_sale'] = $total_price_with_sale;
        $interface_data['total_tax_price'] = $total_tax_price;

        if (self::$terminal_data == FALSE) {
            self::$terminal_data = $interface_data;
        }

        if ($marker == 'interface') {
            return self::$terminal_data;
        } elseif ($marker == 'total_tax_price') {
            return self::$terminal_data['total_tax_price'];
        } else {
            return self::$terminal_data['total_price_with_sale'];
        }
    }

    /**
     * Итоговый налог / Total tax
     * 
     * @param array $tax_data (массив с данными по налогу / array with tax data)
     * @param string $price_with_sale (цена с учетом скидок / price with sales)
     * @param string $currency (валюта / currency)
     * @return string (итоговый налог / total tax)
     */
    public static function totalTax($tax_data, $price_with_sale) {

        if ($tax_data['fixed'] == '1') {
            $tax_out = $price_with_sale / 100 * $tax_data['rate'];
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

        $active_modules = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['discount', '1']);
        $currency = $input['currency'];
        $input_price = \eMarket\Ecb::currencyPrice($input['price'], $currency);

        $discounts_interfaces = [];

        $total_discount = 0;
        foreach ($active_modules as $module) {
            $namespace = '\eMarket\Modules\Discount\\' . ucfirst($module['name']);
            array_push($discounts_interfaces, $namespace::dataInterface($input, $language));
        }
        foreach ($discounts_interfaces as $value) {
            if ($value['sales'] != 'false') {
                foreach ($value['sales'] as $val) {
                    $total_discount = $total_discount + $val;
                }
            }
        }
        $discounts_price = $input['price'] / 100 * (100 - $total_discount);

        if ($discounts_price != 0 && $discounts_price != $input_price) {

            $interface = [
                'out_price' => $discounts_price,
                'total_discount' => $total_discount,
                'interface' => $discounts_interfaces
            ];
            return $interface;
        } else {
            $interface = [
                'out_price' => $input_price,
                'total_discount' => $total_discount,
                'interface' => $discounts_interfaces
            ];

            return $interface;
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