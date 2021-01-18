<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Products
 *
 * @package Products
 * @author eMarket
 * 
 */
class Products {

    public static $stiker_data = FALSE;
    public static $new_products = FALSE;
    public static $product_data = FALSE;
    public static $category_data = FALSE;
    private static $manufacturer = FALSE;
    private static $vendor_codes = FALSE;
    private static $weight = FALSE;
    private static $length = FALSE;

    /**
     * New products data
     *
     * @param string $count Number of new products
     */
    public static function newProducts($count) {
        if (self::$new_products == FALSE) {
            self::$new_products = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND status=? ORDER BY id DESC LIMIT " . $count . "", [lang('#lang_all')[0], 1]);
        }
    }

    /**
     * Product data
     *
     * @param string $id Product id
     * @param string $language Language
     * @return array
     */
    public static function productData($id, $language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }
        self::$product_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? AND language=? AND status=?", [$id, $language, 1])[0];
        return self::$product_data;
    }

    /**
     * Categury data
     *
     * @param string $id Category id
     * @param string $language Language
     * @return array
     */
    public static function categoryData($id, $language = null) {

        if (self::$category_data == FALSE) {
            if ($language == null) {
                $language = lang('#lang_all')[0];
            }
            self::$category_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_CATEGORIES . " WHERE language=? AND id=?", [$language, $id])[0];
            return self::$category_data;
        }

        if (self::$category_data != FALSE) {
            return self::$category_data;
        }
    }

    /**
     * Manufacturer data
     *
     * @param string $id Id
     * @return array|FALSE 
     */
    public static function manufacturer($id) {

        if (self::$manufacturer == FALSE) {
            self::$manufacturer = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_MANUFACTURERS . " WHERE language=?", [lang('#lang_all')[0]]);
        }

        foreach (self::$manufacturer as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Vendor code data
     *
     * @param string $id Id
     * @return array|FALSE
     */
    public static function vendorCode($id) {

        if (self::$vendor_codes == FALSE) {
            self::$vendor_codes = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_VENDOR_CODES . " WHERE language=?", [lang('#lang_all')[0]]);
        }

        foreach (self::$vendor_codes as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Weight data
     *
     * @param string $id Id
     * @return array|FALSE
     */
    public static function weight($id) {

        if (self::$weight == FALSE) {
            self::$weight = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_WEIGHT . " WHERE language=?", [lang('#lang_all')[0]]);
        }

        foreach (self::$weight as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Length data
     *
     * @param string $id Id
     * @return array|FALSE
     */
    public static function length($id) {

        if (self::$length == FALSE) {
            self::$length = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_LENGTH . " WHERE language=?", [lang('#lang_all')[0]]);
        }

        foreach (self::$length as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Stock item
     *
     * @param string $date_available Date_available
     * @param string $quantity Quantity
     * @return array
     */
    public static function inStock($date_available, $quantity) {
        if ($date_available != NULL && $date_available != FALSE && strtotime($date_available) > strtotime(date('Y-m-d'))) {
            $date_available_marker = 'false';
            $date_available_text = lang('product_in_stock_from') . ' ' . \eMarket\Core\Settings::dateLocale($date_available);
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
     * Stikers
     * 
     * @param array $input Input data
     * @param string $class Bootstrap class
     * @param string $class2 Bootstrap class
     * @return string
     */
    public static function stikers($input, $class = null, $class2 = null) {

        if ($class == null) {
            $class = 'danger';
        }
        if ($class2 == null) {
            $class2 = 'success';
        }
        if (self::$stiker_data == false) {
            self::$stiker_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [lang('#lang_all')[0]]);
        }
        $stiker_name = [];
        foreach (self::$stiker_data as $val) {
            $stiker_name[$val['id']] = $val['name'];
        }

        $INTERFACE = new \eMarket\Core\Interfaces();
        \eMarket\Core\Ecb::discountHandler($input);
        $discount_handler = $INTERFACE->load('discountHandler', 'data', 'discounts_data');

        $discount_total_sale = 0;
        foreach ($discount_handler as $data) {
            if ($data['discounts'] != 'false') {
                foreach ($data['discounts'] as $total_sale) {
                    $discount_total_sale = $discount_total_sale + $total_sale;
                }
            }
        }

        if (isset($discount_total_sale) && $discount_total_sale > 0 && $input['stiker'] != '' && $input['stiker'] != NULL) {
            return '<div class="labelsblock"><div class="' . $class . '">- ' . $discount_total_sale . '%</div><div class="' . $class2 . '">' . $stiker_name[$input['stiker']] . '</div></div>';
        }

        if ($input['stiker'] != '' && $input['stiker'] != NULL) {
            return '<div class="labelsblock"><div class="' . $class2 . '">' . $stiker_name[$input['stiker']] . '</div></div>';
        }

        if (isset($discount_total_sale) && $discount_total_sale > 0) {
            return '<div class="labelsblock"><div class="' . $class . '">- ' . $discount_total_sale . '%</div></div>';
        }
        return '';
    }

}