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

    public static $currencies = FALSE;
    public static $terminal_data = FALSE;

    /**
     * Блок вывода цены с учетом скидки
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $marker (маркер для \eMarket\Products::formatPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function priceInterface($input, $marker, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }

        $discount_sale = self::outPrice($input)['discount_sale'];
        if ($discount_sale['names'] != 'false') {
            $discount_count = count($discount_sale['names']);
            $discount_names = '';

            foreach ($discount_sale['names'] as $name_val) {
                $discount_names .= $name_val . '<br>';
            }
        }

        $price_val = self::currencyPrice($input['price'], $input['currency']);

        if (\eMarket\Set::path() == 'admin') {
            if ($price_val != $discount_sale['price'] && $discount_count == 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . $discount_names . '" class="label label-' . $class . '">' . \eMarket\Ecb::formatPrice($discount_sale['price'], $marker) . '</span> <del>' . \eMarket\Ecb::formatPrice($price_val, $marker) . '</del>';
            }
            if ($price_val != $discount_sale['price'] && $discount_count > 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . lang('modules_discount_sale_admin_tooltip_warning') . $discount_names . '" class="label label-warning"><u>' . \eMarket\Ecb::formatPrice($discount_sale['price'], $marker) . '</u></span> <del>' . \eMarket\Ecb::formatPrice($price_val, $marker) . '</del>';
            }
            return \eMarket\Ecb::formatPrice($price_val, $marker);
        }

        if (\eMarket\Set::path() == 'catalog') {
            if ($price_val != $discount_sale['price']) {
                return '<del>' . \eMarket\Ecb::formatPrice($price_val, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Ecb::formatPrice($discount_sale['price'], $marker) . '</span>';
            }
            return \eMarket\Ecb::formatPrice($price_val, $marker);
        }
    }

    /**
     * Блок вывода цены в корзине с учетом скидки
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $marker (маркер для \eMarket\Products::formatPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function priceCartInterface($input, $marker, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }
        $discount_sale = self::outPrice($input)['discount_sale'];

        $price_val = self::currencyPrice($input['price'], $input['currency']);

        if ($price_val != $discount_sale['price']) {
            return '<del>' . \eMarket\Ecb::formatPrice($price_val * \eMarket\Cart::productQuantity($input['id'], 1), $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Ecb::formatPrice($discount_sale['price'] * \eMarket\Cart::productQuantity($input['id'], 1), $marker) . '</span>';
        }
        return \eMarket\Ecb::formatPrice($price_val * \eMarket\Cart::productQuantity($input['id'], 1), $marker);
    }

    /**
     * Блок вывода цены в корзине с учетом скидки
     * 
     * @param string $marker (маркер для \eMarket\Products::formatPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function totalPriceCartInterface($marker, $class = null) {

        $total_price_with_sale = self::priceTerminal();
        $price_val = \eMarket\Cart::totalPrice();

        if ($class == null) {
            $class = 'danger';
        }

        if ($price_val != $total_price_with_sale) {
            return '<del>' . \eMarket\Ecb::formatPrice($price_val, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Ecb::formatPrice($total_price_with_sale, $marker) . '</span>';
        }
        return \eMarket\Ecb::formatPrice($price_val, $marker);
    }

    /**
     * Ценовой терминал корзины
     * 
     * @return array (выходные данные)
     */
    public static function priceTerminal($marker = null) {

        if (self::$terminal_data != FALSE) {
            if ($marker == 'interface') {
                return self::$terminal_data;
            } else {
                return self::$terminal_data['total_price_with_sale'];
            }
        }

        $total_price_with_sale = 0;
        $output_data = [];

        $taxes_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_TAXES . " WHERE language=?", [lang('#lang_all')[0]]);

        if (isset($_SESSION['cart'])) {
            $x = 0;
            foreach ($_SESSION['cart'] as $value) {
                $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$value['id'], lang('#lang_all')[0]])[0];
                if ($data != FALSE) {
                    $discount_sale = self::outPrice($data)['discount_sale'];
                    $discount_total_sale = 0;

                    $tax = [];
                    foreach ($taxes_data as $tax_data) {
                        if ($tax_data['id'] == $data['tax']) {
                            $tax = $tax_data;
                        }
                    }

                    if ($discount_sale['sales'] != 'false') {
                        foreach ($discount_sale['sales'] as $total_sale) {
                            $discount_total_sale = $discount_total_sale + $total_sale;
                        }
                        $total_price_with_sale = $total_price_with_sale + (self::currencyPrice($data['price'], $data['currency']) * $value['quantity'] / 100 * (100 - $discount_total_sale));

                        $interface = [
                            'id' => $value['id'],
                            'price' => $data['price'],
                            'currency' => $data['currency'],
                            'price_with_currency' => self::currencyPrice($data['price'], $data['currency']),
                            'quantity' => $value['quantity'],
                            'discount_sale' => $discount_sale,
                            'tax' => $tax
                        ];

                        array_push($output_data, $interface);
                    } else {
                        $total_price_with_sale = $total_price_with_sale + (self::currencyPrice($data['price'], $data['currency']) * $value['quantity']);

                        $interface = [
                            'id' => $value['id'],
                            'price' => $data['price'],
                            'currency' => $data['currency'],
                            'price_with_currency' => self::currencyPrice($data['price'], $data['currency']),
                            'quantity' => $value['quantity'],
                            'discount_sale' => $discount_sale,
                            'tax' => $tax
                        ];

                        array_push($output_data, $interface);
                    }
                } else {
                    unset($_SESSION['cart'][$x]);
                }
                $x++;
            }
        }
        $output_data['total_price_with_sale'] = $total_price_with_sale;

        if (self::$terminal_data == FALSE) {
            self::$terminal_data = $output_data;
        }

        if ($marker == 'interface') {
            return self::$terminal_data;
        } else {
            return self::$terminal_data['total_price_with_sale'];
        }
    }

    /**
     * Блок вывода итоговой цены товара
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @return array (выходные данные)
     */
    public static function outPrice($input) {
        //Модуль скидки \eMarket\Modules\Discount\Sale
        $discount_sale = \eMarket\Modules\Discount\Sale::dataInterface($input);

        $output = [
            'out_price' => $discount_sale['price'],
            'discount_sale' => $discount_sale
        ];
        return $output;
    }

    /**
     * Стоимость с учетом валюты
     *
     * @param string $price (значение стоимости)
     * @param string $currency (id валюты)
     * @return string|FALSE string (стоимость с учетом валюты)
     */
    public static function currencyPrice($price, $currency) {

        if (self::$currencies == FALSE) {
            self::$currencies = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);
        }
        foreach (self::$currencies as $value) {
            if ($value['id'] == $currency) {
                return $price / $value['value'];
            }
        }
        return FALSE;
    }

    /**
     * Данные стоимости товара
     *
     * @param string $price (цена)
     * @param string $format (выводить стоимость в форматированном виде: 0 - полное наим., 1- сокращ. наим., 2 - знак валюты, 3 - ISO код)
     * @param string $language (язык для отображения)
     * @return array $price (данные по стоимости)
     */
    public static function formatPrice($price, $format = null, $language = null) {

        if ($language == null) {
            $CURRENCIES = \eMarket\Set::currencyDefault();
        } else {
            $CURRENCIES = \eMarket\Set::currencyDefault($language);
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