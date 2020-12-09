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
    
    public static $CURRENCIES = FALSE;

    /**
     * Данные по товару
     *
     * @param string $count (количество новых товаров)
     * @return array $product (массив с данными по товару)
     */
    public static function viewNew($count) {


        $product = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND status=? ORDER BY id DESC LIMIT " . $count . "", [lang('#lang_all')[0], 1]);
        return $product;
    }

    /**
     * Данные по товару
     *
     * @param string $id (id товара)
     * @param string $language (язык отображения)
     * @return array|FALSE $product (данные по товару)
     */
    public static function productData($id, $language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }

        $product = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=? AND status=?", [$id, $language, 1]);

        if (count($product) > 0) {
            return $product[0];
        } else {
            return FALSE;
        }
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
     * Вывод имени по id
     *
     * @param string $id (id в таблице)
     * @param string $db (таблица)
     * @param string $column (колонка)
     * @return string $output (название)
     */
    public static function nameToId($id, $db, $column) {
        if ($id != NULL) {
            $output = \eMarket\Pdo::getCellFalse("SELECT " . $column . " FROM " . $db . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        } else {
            $output = NULL;
        }
        return $output;
    }

    /**
     * Товар на складе
     *
     * @param string $date_available (id в таблице)
     * @param string $quantity (количество)
     * @return array (выходной массив)
     */
    public static function inStock($date_available, $quantity) {
        if ($date_available != NULL && $date_available != FALSE && strtotime($date_available) > strtotime(date('Y-m-d'))) {
            $date_available_marker = 'false';
            $date_available_text = lang('product_in_stock_from') . ' ' . \eMarket\Set::dateLocale($date_available);
        } elseif ($quantity != NULL && $quantity <= 0) {
            $date_available_text = lang('product_out_of_stock');
            $date_available_marker = 'true';
        } else {
            $date_available_marker = 'true';
            $date_available_text = lang('product_in_stock');
        }

        if ($date_available_marker == 'false') {
            return '<span class="label label-warning">' . $date_available_text . '</span>';
        } elseif ($quantity != NULL && $quantity <= 0) {
            return '<span class="label label-danger">' . $date_available_text . '</span>';
        } else {
            return '<span class="label label-success">' . $date_available_text . '</span>';
        }
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
     * Данные по категории товара
     *
     * @param string $price (значение стоимости)
     * @return string $currency (валюта)
     */
    public static function currencyPrice($price, $currency) {

        if (self::$CURRENCIES == FALSE) {
            self::$CURRENCIES = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);
        }
        foreach (self::$CURRENCIES as $value){
            if ($value['id'] == $currency){
                return $price / $value['value'];
            }
        }
    }

    /**
     * Данные стоимости товара
     *
     * @param string $price (цена)
     * @param string $format (выводить стоимость в форматированном виде: 0 - полное наим., 1- сокращ. наим., 2 - знак валюты, 3 - ISO код)
     * @param string $language (язык для отображения)
     * @return array $price (данные по стоимости)
     */
    public static function productPrice($price, $format = null, $language = null) {

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