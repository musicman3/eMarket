<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Cart,
    Interfaces,
    Pdo,
    Settings,
};

/**
 * eMarket Calculated Block
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class Ecb {

    private static $active_modules = FALSE;

    /**
     * View price
     * 
     * @param array $input Array with products data
     * @param int $marker Format currency marker
     * @param int|string $quantity Quantity
     * @param string $class Bootstrap class for sale
     * @return string Output data
     */
    public static function priceInterface(array $input, ?int $marker = null, int|string $quantity = 1, string $class = 'danger'): string {

        $INTERFACE = new Interfaces();

        self::discountHandler($input);
        $discounts_data = $INTERFACE->load('discountHandler', 'data', 'discounts_data');
        $discounted_price = self::currencyPrice($INTERFACE->load('discountHandler', 'data', 'out_price'), $input['currency']);

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

        if (Settings::path() == 'admin') {
            if ($discounts_data != [] && $input_price != $discounted_price && $count == 1) {
                return '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="' . $discount_names . '" class="badge bg-' . $class . '">' . self::formatPrice($discounted_price, $marker) . '</span> <del>' . self::formatPrice($input_price, $marker) . '</del>';
            }
            if ($discounts_data != [] && $input_price != $discounted_price && $count > 1) {
                return '<span data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="' . lang('modules_discount_sale_admin_tooltip_warning') . $discount_names . '" class="badge bg-warning">' . self::formatPrice($discounted_price, $marker) . '</span> <del>' . self::formatPrice($input_price, $marker) . '</del>';
            }
            return self::formatPrice($input_price, $marker);
        }

        if (Settings::path() == 'catalog') {
            if ($discounts_data != [] && $input_price != $discounted_price) {
                return '<del>' . self::formatPrice($input_price * $quantity, $marker) . '</del> <span class="badge bg-' . $class . '">' . self::formatPrice($discounted_price * $quantity, $marker) . '</span>';
            }
            return self::formatPrice($input_price * $quantity, $marker);
        }
    }

    /**
     * Total in cart
     * 
     * @param int $marker Format currency marker
     * @param string $class Bootstrap class for sale
     * @return string Output data
     */
    public static function totalPriceCartInterface(?int $marker = null, string $class = 'danger'): string {

        $INTERFACE = new Interfaces();
        self::priceTerminal();
        $discounted_price = $INTERFACE->load('priceTerminal', 'data', 'discounted_price');

        $total_price = Cart::totalPrice();

        if ($total_price != $discounted_price) {
            return '<del>' . self::formatPrice($total_price, $marker) . '</del><br><span class="badge bg-' . $class . '">' . self::formatPrice($discounted_price, $marker) . '</span>';
        }
        return self::formatPrice($total_price, $marker);
    }

    /**
     * Price terminal
     * 
     * @param string $language Language
     */
    public static function priceTerminal(?string $language = null): void {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }

        $discounted_total_price = 0;
        $total_price_with_tax = 0;
        $price_terminal_data = [];

        $INTERFACE = new Interfaces();

        $taxes_data = Pdo::getAssoc("SELECT * FROM " . TABLE_TAXES . " WHERE language=?", [$language]);

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $value) {
                $data = Pdo::getAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$value['id'], $language])[0];
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
     * Total tax
     * 
     * @param array $tax_data Array with tax data
     * @param float $discounted_price Price with sales
     * @return float Total tax
     */
    public static function totalTax(array $tax_data, float $discounted_price): float {

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
     * Discount handler
     * 
     * @param array $input (Array with product data
     * @param string $language Language
     */
    public static function discountHandler(array $input, ?string $language = null): void {

        if (self::$active_modules == FALSE) {
            self::$active_modules = Pdo::getAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=?", ['discount', '1']);
        }

        $input_price = self::currencyPrice($input['price'], $input['currency']);

        $discounts_data = [];
        $INTERFACE = new Interfaces();

        $total_discount = 0;

        foreach (self::$active_modules as $module) {
            $namespace = '\eMarket\Core\Modules\Discount\\' . ucfirst($module['name']);
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
     * Price with currency
     *
     * @param float|string $price Price value
     * @param int|string $currency Currency
     * @return float|bool Price with currency
     */
    public static function currencyPrice(float|string $price, int|string $currency): float|bool {

        $currencies = Settings::currenciesData();

        foreach ($currencies as $value) {
            if ($value['id'] == $currency) {
                return $price / $value['value'];
            }
        }
        return FALSE;
    }

    /**
     * Price with region format
     *
     * @param float|string $price Price
     * @param int $format Format flag (Example: 0 - Dollar USA, 1 - doll., 2 - $, 3 - USD)
     * @param string $language Language
     * @return string Format price data
     */
    public static function formatPrice(float|string $price, ?int $format = null, ?string $language = null): string {

        if ($language == null) {
            $CURRENCIES = Settings::currencyDefault();
        } else {
            $CURRENCIES = Settings::currencyDefault($language);
        }

        if ($format == 0) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[1] . ' ' . number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language)) . ' ' . $CURRENCIES[1];
            }
        }

        if ($format == 1) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[2] . ' ' . number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language)) . ' ' . $CURRENCIES[2];
            }
        }

        if ($format == 2) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[7] . number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language)) . $CURRENCIES[7];
            }
        }

        if ($format == 3) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[3] . ' ' . number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language)) . ' ' . $CURRENCIES[3];
            }
        }

        return number_format($price * $CURRENCIES[5], (int) $CURRENCIES[9], lang('currency_separator', $language), lang('currency_group_separator', $language));
    }

}
