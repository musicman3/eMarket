<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use eMarket\Core\{
    Eac,
    Ecb,
    Func,
    Modules,
    Navigation,
    Pdo,
    Settings,
    Valid
};
use eMarket\Admin\{
    HeaderMenu,
    Stickers
};

/**
 * Stock
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Stock {

    public static $json_data_category = FALSE;
    public static $json_data_product = FALSE;
    public static $resize_param = FALSE;
    public static $resize_param_product = FALSE;
    public static $idsx_real_parent_id = FALSE;
    public static $parent_id = FALSE;
    public static $currencies_all = FALSE;
    public static $taxes_all = FALSE;
    public static $units_all = FALSE;
    public static $length_all = FALSE;
    public static $weight_all = FALSE;
    public static $vendor_codes_all = FALSE;
    public static $manufacturers_all = FALSE;
    public static $ses_verify = FALSE;
    public static $attributes_category = FALSE;
    public static $transfer = FALSE;
    public static $count_lines_cat = FALSE;
    public static $count_lines_prod = FALSE;
    public static $count_lines_merge = FALSE;
    public static $arr_merge = FALSE;
    public static $start = FALSE;
    public static $finish = FALSE;
    public static $lines_cat = FALSE;
    public static $lines_prod = FALSE;
    public static $sql_data_cat = FALSE;
    public static $sql_data_prod = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->imgUploadCategories();
        $this->imgUploadProducts();
        $this->initEac();
        Modules::initDiscount();
        Stickers::initStickers();
        $this->selectData();
        $this->preparedData();
        $this->data();
        $this->modalCategories();
        $this->modalProducts();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu() {
        HeaderMenu::$menu[HeaderMenu::$menu_market][0] = ['?route=stock', 'bi-shop-window', lang('title_stock_index'), '', 'false'];
    }

    /**
     * Image Upload for Categories
     *
     */
    public function imgUploadCategories() {
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '94']); // width, height
    }

    /**
     * Image Upload for Products
     *
     */
    public function imgUploadProducts() {
        self::$resize_param_product = [];
        array_push(self::$resize_param_product, ['125', '94']); // width, height
        array_push(self::$resize_param_product, ['200', '150']);
        array_push(self::$resize_param_product, ['325', '244']);
        array_push(self::$resize_param_product, ['525', '394']);
        array_push(self::$resize_param_product, ['850', '638']);
    }

    /**
     * Init Eac
     *
     */
    public function initEac() {
        $EAC_ENGINE = Eac::init(self::$resize_param, self::$resize_param_product);
        self::$idsx_real_parent_id = $EAC_ENGINE[0];
        self::$parent_id = $EAC_ENGINE[1];
    }

    /**
     * Select Data
     *
     */
    public function selectData() {
        self::$currencies_all = Pdo::getAssoc("SELECT name, default_value, id FROM " . TABLE_CURRENCIES . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$taxes_all = Pdo::getAssoc("SELECT name, id FROM " . TABLE_TAXES . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$units_all = Pdo::getAssoc("SELECT name, default_unit, id FROM " . TABLE_UNITS . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$length_all = Pdo::getAssoc("SELECT name, default_length, id FROM " . TABLE_LENGTH . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$weight_all = Pdo::getAssoc("SELECT name, default_weight, id FROM " . TABLE_WEIGHT . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$vendor_codes_all = Pdo::getAssoc("SELECT name, default_vendor_code, id FROM " . TABLE_VENDOR_CODES . " WHERE language=?", [lang('#lang_all')[0]]);
        self::$manufacturers_all = Pdo::getAssoc("SELECT name, id FROM " . TABLE_MANUFACTURERS . " WHERE language=?", [lang('#lang_all')[0]]);
    }

    /**
     * Prepared Data
     *
     */
    public function preparedData() {
        if (Valid::inGET('nav_parent_id')) {
            self::$parent_id = Valid::inGET('nav_parent_id');
        }

        if (!isset(self::$idsx_real_parent_id)) {
            self::$idsx_real_parent_id = '';
        }

        if (isset($_SESSION['buffer'])) {
            self::$ses_verify = count($_SESSION['buffer']);
        } else {
            self::$ses_verify = '0';
        }

        if (self::$parent_id == 0) {
            self::$attributes_category = json_encode(json_encode([]));
        } else {
            self::$attributes_category = json_encode(Pdo::getAssoc("SELECT attributes FROM " . TABLE_CATEGORIES . " WHERE id=? AND language=?", [
                        self::$parent_id, lang('#lang_all')[0]])[0]['attributes']);
        }

        self::$transfer = 0;
    }

    /**
     * Data
     *
     */
    public function data() {
        $search = '%' . Valid::inGET('search') . '%';
        if (Valid::inGET('search')) {

            $sql_data_cat_search = Pdo::getAssoc("SELECT id FROM " . TABLE_CATEGORIES . " WHERE name LIKE? AND language=? ORDER BY sort_category DESC", [
                        $search, lang('#lang_all')[0]]);

            self::$sql_data_cat = [];
            foreach ($sql_data_cat_search as $sql_data_cat_search_val) {
                foreach (Pdo::getAssoc("SELECT * FROM " . TABLE_CATEGORIES . " WHERE id=? ORDER BY sort_category DESC", [
                    $sql_data_cat_search_val['id']]) as $cat_array) {
                    self::$sql_data_cat[] = $cat_array;
                }
            }
            self::$lines_cat = Func::filterData(self::$sql_data_cat, 'language', lang('#lang_all')[0]);

            $sql_data_prod_search = Pdo::getAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE (name LIKE? OR description LIKE?) AND language=? ORDER BY id DESC", [$search, $search, lang('#lang_all')[0]]);
            self::$sql_data_prod = [];
            foreach ($sql_data_prod_search as $sql_data_prod_search_val) {
                foreach (Pdo::getAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? ORDER BY id DESC", [
                    $sql_data_prod_search_val['id']]) as $prod_array) {
                    self::$sql_data_prod[] = $prod_array;
                }
            }
            self::$lines_prod = Func::filterData(self::$sql_data_prod, 'language', lang('#lang_all')[0]);
        } else {
            self::$sql_data_cat = Pdo::getAssoc("SELECT * FROM " . TABLE_CATEGORIES . " WHERE parent_id=? ORDER BY sort_category DESC", [self::$parent_id]);
            self::$lines_cat = Func::filterData(self::$sql_data_cat, 'language', lang('#lang_all')[0]);
            self::$sql_data_prod = Pdo::getAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE parent_id=? ORDER BY id DESC", [self::$parent_id]);
            self::$lines_prod = Func::filterData(self::$sql_data_prod, 'language', lang('#lang_all')[0]);
        }

        self::$count_lines_cat = count(self::$lines_cat);
        self::$count_lines_prod = count(self::$lines_prod);
        self::$count_lines_merge = self::$count_lines_cat + self::$count_lines_prod;


        self::$arr_merge = Func::arrayMergeOriginKey('cat', 'prod', self::$lines_cat, self::$lines_prod);

        $navigate = Navigation::data(self::$count_lines_merge, Settings::linesOnPage(), 1);
        self::$start = $navigate[0];
        self::$finish = $navigate[1];
    }

    /**
     * Categories Modal
     *
     */
    public function modalCategories() {
        self::$json_data_category = json_encode(json_encode([]));
        $name = [];
        for ($i = self::$start; $i < self::$finish; $i++) {
            if (isset(self::$lines_cat[$i]['id']) == TRUE) {

                $modal_id = self::$lines_cat[$i]['id'];

                foreach (self::$sql_data_cat as $sql_modal_cat) {
                    if ($sql_modal_cat['id'] == $modal_id) {
                        $name[array_search($sql_modal_cat['language'], lang('#lang_all'))][$modal_id] = $sql_modal_cat['name'];
                    }
                    if ($sql_modal_cat['language'] == lang('#lang_all')[0] && $sql_modal_cat['id'] == $modal_id) {
                        $logo[$modal_id] = json_decode($sql_modal_cat['logo'], 1);
                        $logo_general[$modal_id] = $sql_modal_cat['logo_general'];
                        $attributes[$modal_id] = json_decode($sql_modal_cat['attributes']);
                    }
                }

                ksort($name);

                self::$json_data_category = json_encode([
                    'name' => $name,
                    'logo' => $logo,
                    'logo_general' => $logo_general,
                    'attributes' => $attributes
                ]);
            }
        }
    }

    /**
     * Products Modal
     *
     */
    public function modalProducts() {
        self::$json_data_product = json_encode([]);
        $name_product = [];
        $description_product = [];
        $keyword_product = [];
        $tags_product = [];
        for ($i = self::$start; $i < self::$finish; $i++) {
            if (isset(self::$arr_merge['prod'][$i . 'a']['id']) == TRUE) {

                $modal_id_prod = self::$arr_merge['prod'][$i . 'a']['id'];

                foreach (self::$sql_data_prod as $sql_modal_prod) {
                    if ($sql_modal_prod['id'] == $modal_id_prod) {
                        $name_product[array_search($sql_modal_prod['language'], lang('#lang_all'))][$modal_id_prod] = $sql_modal_prod['name'];
                        $description_product[array_search($sql_modal_prod['language'], lang('#lang_all'))][$modal_id_prod] = $sql_modal_prod['description'];
                        $keyword_product[array_search($sql_modal_prod['language'], lang('#lang_all'))][$modal_id_prod] = $sql_modal_prod['keyword'];
                        $tags_product[array_search($sql_modal_prod['language'], lang('#lang_all'))][$modal_id_prod] = $sql_modal_prod['tags'];
                    }
                    if ($sql_modal_prod['language'] == lang('#lang_all')[0] && $sql_modal_prod['id'] == $modal_id_prod) {
                        $price_product[$modal_id_prod] = round(Ecb::currencyPrice($sql_modal_prod['price'], $sql_modal_prod['currency']), 2);
                        $currency_product[$modal_id_prod] = Settings::currencyDefault()[0];
                        $quantity_product[$modal_id_prod] = $sql_modal_prod['quantity'];
                        $units_product[$modal_id_prod] = $sql_modal_prod['unit'];
                        $model_product[$modal_id_prod] = $sql_modal_prod['model'];
                        $manufacturers_product[$modal_id_prod] = $sql_modal_prod['manufacturer'];
                        $date_available_product[$modal_id_prod] = $sql_modal_prod['date_available'];
                        $tax_product[$modal_id_prod] = $sql_modal_prod['tax'];
                        $vendor_code_value_product[$modal_id_prod] = $sql_modal_prod['vendor_code_value'];
                        $vendor_code_product[$modal_id_prod] = $sql_modal_prod['vendor_code'];
                        $weight_value_product[$modal_id_prod] = $sql_modal_prod['weight_value'];
                        $weight_product[$modal_id_prod] = $sql_modal_prod['weight'];
                        $min_quantity_product[$modal_id_prod] = $sql_modal_prod['min_quantity'];
                        $dimension_product[$modal_id_prod] = $sql_modal_prod['dimension'];
                        $length_product[$modal_id_prod] = $sql_modal_prod['length'];
                        $width_product[$modal_id_prod] = $sql_modal_prod['width'];
                        $height_product[$modal_id_prod] = $sql_modal_prod['height'];
                        $logo_product[$modal_id_prod] = json_decode($sql_modal_prod['logo'], 1);
                        $logo_general_product[$modal_id_prod] = $sql_modal_prod['logo_general'];
                        $attributes_product[$modal_id_prod] = json_decode($sql_modal_prod['attributes'], 1);

                        if (self::$parent_id == 0) {
                            $attributes_data[$modal_id_prod] = json_encode(json_encode([]));
                        } else {
                            $attributes_data[$modal_id_prod] = json_encode(
                                    Pdo::getAssoc("SELECT attributes FROM " . TABLE_CATEGORIES . " WHERE id=? AND language=?", [
                                        self::$parent_id, lang('#lang_all')[0]])[0]['attributes']
                            );
                        }
                    }
                }

                ksort($name_product);
                ksort($description_product);
                ksort($keyword_product);
                ksort($tags_product);

                self::$json_data_product = json_encode([
                    'name' => $name_product,
                    'description' => $description_product,
                    'keyword' => $keyword_product,
                    'tags' => $tags_product,
                    'price' => $price_product,
                    'currency' => $currency_product,
                    'quantity' => $quantity_product,
                    'units' => $units_product,
                    'model' => $model_product,
                    'manufacturers' => $manufacturers_product,
                    'date_available' => $date_available_product,
                    'tax' => $tax_product,
                    'vendor_code_value' => $vendor_code_value_product,
                    'vendor_code' => $vendor_code_product,
                    'weight_value' => $weight_value_product,
                    'weight' => $weight_product,
                    'min_quantity' => $min_quantity_product,
                    'dimension' => $dimension_product,
                    'length' => $length_product,
                    'width' => $width_product,
                    'height' => $height_product,
                    'logo' => $logo_product,
                    'logo_general' => $logo_general_product,
                    'attributes' => $attributes_product,
                    'attributes_data' => $attributes_data
                ]);
            }
        }
    }

    /**
     * Class for categories status
     *
     * @param string $class1 class
     * @param string $class2 class
     * @return string
     */
    public static function statusCatClass($class1, $class2) {

        if (self::$arr_merge['cat'][self::$start]['status'] == 1) {
            return $class1;
        } else {
            return $class2;
        }
    }

    /**
     * Class for categories button
     *
     * @param string $class1 class
     * @param string $class2 class
     * @return string
     */
    public static function statusCatButton($class1, $class2) {

        if (isset($_SESSION['buffer']['cat']) == true && in_array(self::$arr_merge['cat'][self::$start]['id'], $_SESSION['buffer']['cat']) == true) {
            return $class1;
        } elseif (self::$transfer == Settings::linesOnPage()) {
            return $class2;
        } else {
            return false;
        }
    }

    /**
     * Class for products status
     *
     * @param string $class1 class
     * @param string $class2 class
     * @param string $class3 class
     * @return string
     */
    public static function statusProdClass($class1, $class2, $class3 = null) {
        if ($class3 == null) {
            $disabled = '';
        }
        if (isset($_SESSION['buffer']['prod']) == true && in_array(self::$arr_merge['prod'][self::$start . 'a']['id'], $_SESSION['buffer']['prod']) == true) {
            $disabled = $class3;
        } else {
            $disabled = '';
        }
        if (self::$arr_merge['prod'][self::$start . 'a']['status'] == 1) {
            return $class1 . ' ' . $disabled;
        } else {
            return $class2 . ' ' . $disabled;
        }
    }

    /**
     * Class for discount
     *
     * @param string $class1 class
     * @param string $class2 class
     * @return string
     */
    public static function discountClass($class1, $class2) {

        if (json_decode(Stock::$arr_merge['prod'][Stock::$start . 'a']['discount'], 1)) {
            return $class1;
        }
        if (json_decode(Stock::$arr_merge['prod'][Stock::$start . 'a']['discount'], 1) == 0) {
            return $class2;
        }
    }

    /**
     * Data for sticker
     *
     * @param string $span1 span start
     * @param string $span2 span end
     * @return string
     */
    public static function stickerData($span1, $span2) {

        if (Stock::$arr_merge['prod'][Stock::$start . 'a']['sticker'] != '' && Stock::$arr_merge['prod'][Stock::$start . 'a']['sticker'] != NULL) {
            return $span1 . Stickers::$sticker_name[Stock::$arr_merge['prod'][Stock::$start . 'a']['sticker']] . $span2;
        } else {
            return '';
        }
    }

    /**
     * Class for transfer
     *
     * @param string $class class
     * @return string
     */
    public static function transferClass($class) {

        if (self::$transfer == Settings::linesOnPage()) {
            return $class;
        }
    }

    /**
     * Tooltip data for product discounts
     *
     * @param string $discount Data on discounts in a line separated by commas
     * @return string
     */
    public static function productSaleTooltip($discount) {

        $discount_json = json_decode($discount, 1);
        $text = '';
        foreach ($discount_json as $key => $id) {
            foreach ($id as $val_id) {
                $text .= lang('modules_discount_' . $key . '_name') . ': ' . Pdo::getValue("SELECT name FROM " . DB_PREFIX . 'modules_discount_' . $key . "  WHERE language=? AND id=?", [lang('#lang_all')[0], $val_id]) . '<br>';
            }
        }

        return $text;
    }

    /**
     * Data for sticker
     *
     * @param string $span1 span
     * @param string $span2 span
     * @return string
     */
    public static function discountLabel($span1, $span2) {

        if (self::productSaleTooltip(Stock::$arr_merge['prod'][Stock::$start . 'a']['discount']) != '') {
            return $span1;
        } else {
            return $span2;
        }
    }

    /**
     * Text for categories
     *
     * @param string $class1 class
     * @param string $class2 class
     * @return array
     */
    public static function categoriesText($class1, $class2) {
        if (self::$transfer == Settings::linesOnPage()) {
            $class = $class1;
            $id = self::$arr_merge['cat'][self::$start]['id'];
            $text = lang('categories_transfer');
        } else {
            $class = $class2;
            $id = 'category_' . self::$arr_merge['cat'][self::$start]['id'];
            $text = self::$arr_merge['cat'][Stock::$start]['name'];
        }
        return [$class, $id, $text];
    }

}
