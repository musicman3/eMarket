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

    public static $manufacturer = FALSE;
    public static $vendor_codes = FALSE;
    public static $weight = FALSE;
    public static $length = FALSE;
    public static $stiker_data = FALSE;

    /**
     * Данные по новым товарам
     *
     * @param string $count (количество новых товаров)
     * @return array $product (массив с данными по товарам)
     */
    public static function newProducts($count) {
        $products = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND status=? ORDER BY id DESC LIMIT " . $count . "", [lang('#lang_all')[0], 1]);
        return $products;
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
     * Вывод производителя по id
     *
     * @param string $id (id в таблице)
     * @return array|FALSE $value (данные по производителю)
     */
    public static function manufacturer($id) {
        if (self::$manufacturer == FALSE) {
            $manufacturer = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MANUFACTURERS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        }
        foreach ($manufacturer as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Вывод идентификатора по id
     *
     * @param string $id (id в таблице)
     * @return array|FALSE $value (данные по идентификатору)
     */
    public static function vendorCode($id) {
        if (self::$vendor_codes == FALSE) {
            $vendor_codes = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_VENDOR_CODES . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        }
        foreach ($vendor_codes as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Вывод веса по id
     *
     * @param string $id (id в таблице)
     * @return array|FALSE $value (данные по весу)
     */
    public static function weight($id) {
        if (self::$weight == FALSE) {
            $weight = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_WEIGHT . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        }
        foreach ($weight as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Вывод длины по id
     *
     * @param string $id (id в таблице)
     * @return array|FALSE $value (данные по длине)
     */
    public static function length($id) {
        if (self::$length == FALSE) {
            $length = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_LENGTH . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        }
        foreach ($length as $value) {
            if ($value['id'] == $id) {
                return $value;
            }
        }
        return FALSE;
    }

    /**
     * Товар на складе
     *
     * @param string $date_available (дата появления на складе)
     * @param string $quantity (количество)
     * @return array (выходной массив)
     */
    public static function inStock($date_available, $quantity) {
        if ($date_available != NULL && $date_available != FALSE && strtotime($date_available) > strtotime(date('Y-m-d'))) {
            $date_available_marker = 'false';
            $date_available_text = lang('product_in_stock_from') . ' ' . \eMarket\Settings::dateLocale($date_available);
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
     * Блок вывода стикеров
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $class (класс bootstrap для отображения стикера скидки)
     * @param string $class2 (класс bootstrap для отображения собственного стикера)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function stikers($input, $class = null, $class2 = null) {

        if ($class == null) {
            $class = 'danger';
        }
        if ($class2 == null) {
            $class2 = 'success';
        }
        if (self::$stiker_data == false) {
            self::$stiker_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_STIKERS . " WHERE language=?", [lang('#lang_all')[0]]);
        }
        $stiker_name = [];
        foreach (self::$stiker_data as $val) {
            $stiker_name[$val['id']] = $val['name'];
        }

        $discount_sale = \eMarket\Ecb::outPrice($input)['discount_sale'];
        $discount_total_sale = 0;

        if ($discount_sale['sales'] != 'false') {
            foreach ($discount_sale['sales'] as $total_sale) {
                $discount_total_sale = $discount_total_sale + $total_sale;
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

?>