<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для работы с товарами
 *
 * @package Product
 * @author eMarket
 * 
 */
class Products {

    /**
     * Данные по товару
     *
     * @param string $count (количество новых товаров)
     * @return array $product (массив с данными по товару)
     */
    public static function viewNew($count) {


        $product = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? ORDER BY id DESC LIMIT " . $count . "", [lang('#lang_all')[0]]);
        return $product;
    }

    /**
     * Данные по товару
     *
     * @param string $id (id товара)
     * @param string $language (язык отображения)
     * @return array $product (данные по товару)
     */
    public static function productData($id, $language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }

        $product = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=?", [$id, $language])[0];
        return $product;
    }

    /**
     * Все изображения конкретного товара в массиве
     *
     * @param string $products_new_count (ячейка со списком изображений товара)
     * @return array $image (названия изображений в массиве)
     */
    public static function viewNewImages($products_new_count) {
        $image = explode(',', $products_new_count[6], -1);
        return $image;
    }

    /**
     * Данные по категории товара
     *
     * @param string $id (id категории)
     * @return array $product (данные по категории)
     */
    public static function productCategories($id) {


        $categories = \eMarket\Pdo::getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        return $categories;
    }

    /**
     * Данные стоимости товара
     *
     * @param string $price (цена)
     * @param string $format (выводить стоимость в форматированном виде: 0 - полное наим., 1- сокращ. наим., 2 - знак валюты, 3 - ISO код)
     * @return array $price (данные по стоимости)
     */
    public static function productPrice($price, $format = null) {

        $CURRENCIES = \eMarket\Set::currencyDefault();

        if ($format == 0) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[1] . ' ' . number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator'));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator')) . ' ' . $CURRENCIES[1];
            }
        }

        if ($format == 1) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[2] . ' ' . number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator'));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator')) . ' ' . $CURRENCIES[2];
            }
        }

        if ($format == 2) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[7] . ' ' . number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator'));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator')) . ' ' . $CURRENCIES[7];
            }
        }

        if ($format == 3) {
            if ($CURRENCIES[8] == 'left') {
                return $price_return = $CURRENCIES[3] . ' ' . number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator'));
            }
            if ($CURRENCIES[8] == 'right') {
                return $price_return = number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator')) . ' ' . $CURRENCIES[3];
            }
        }

        return number_format($price * $CURRENCIES[5], $CURRENCIES[9], lang('currency_separator'), lang('currency_group_separator'));
    }

}

?>