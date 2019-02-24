<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

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
    public function viewNew($count) {
        $PDO = new \eMarket\Core\Pdo;

        $product = $PDO->getColRow("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? ORDER BY id DESC LIMIT " . $count . "", [lang('#lang_all')[0]]);
        return $product;
    }

    /**
     * Данные по товару
     *
     * @param string $id (id товара)
     * @return array $product (данные по товару)
     */
    public function productData($id) {
        $PDO = new \eMarket\Core\Pdo;

        $product = $PDO->getColRow("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        return $product;
    }

    /**
     * Все изображения конкретного товара в массиве
     *
     * @param string $products_new_count (ячейка со списком изображений товара)
     * @return array $image (названия изображений в массиве)
     */
    public function viewNewImages($products_new_count) {
        $image = explode(',', $products_new_count[6], -1);
        return $image;
    }

    /**
     * Данные по категории товара
     *
     * @param string $id (id категории)
     * @return array $product (данные по категории)
     */
    public function productCategories($id) {
        $PDO = new \eMarket\Core\Pdo;

        $categories = $PDO->getCell("SELECT name FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        return $categories;
    }

    /**
     * Данные стоимости товара
     *
     * @param string $id (id товара)
     * @param string $format (выводить стоимость в форматированном виде: 0 - полное наим., 1- сокращ. наим., 2 - знак валюты, 3 - ISO код)
     * @return array $price (данные по стоимости)
     */
    public function productPrice($id, $format = null) {
        $PDO = new \eMarket\Core\Pdo;

        $price = $PDO->getCell("SELECT price FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        $currencies = $PDO->getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [lang('#lang_all')[0], 1])[0];
        
        if ($format == 0) {
            if ($currencies[8] == 'left') {
                return $price_return = $currencies[1] . ' ' . number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator'));
            }
            if ($currencies[8] == 'right') {
                return $price_return = number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator')) . ' ' . $currencies[1];
            }
        }

        if ($format == 1) {
            if ($currencies[8] == 'left') {
                return $price_return = $currencies[2] . ' ' . number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator'));
            }
            if ($currencies[8] == 'right') {
                return $price_return = number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator')) . ' ' . $currencies[2];
            }
        }

        if ($format == 2) {
            if ($currencies[8] == 'left') {
                return $price_return = $currencies[7] . ' ' . number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator'));
            }
            if ($currencies[8] == 'right') {
                return $price_return = number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator')) . ' ' . $currencies[7];
            }
        }
        
        if ($format == 3) {
            if ($currencies[8] == 'left') {
                return $price_return = $currencies[3] . ' ' . number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator'));
            }
            if ($currencies[8] == 'right') {
                return $price_return = number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator')) . ' ' . $currencies[3];
            }
        }

        return number_format($price, $currencies[9], lang('currency_separator'), lang('currency_group_separator'));
    }

}

?>