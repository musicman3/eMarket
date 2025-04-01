<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Ecb,
    Func,
    Modules,
    Navigation,
    Pages,
    Settings,
    Valid
};
use eMarket\Admin\{
    Eac,
    HeaderMenu,
    Stickers
};
use Cruder\Db;

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

    public static $routing_parameter = 'stock';
    public $title = 'title_stock_index';
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
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_market][0] = ['?route=stock', 'bi-shop-window', lang('title_stock_index'), '', 'false'];
    }

    /**
     * Image Upload for Categories
     *
     */
    private function imgUploadCategories(): void {
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '94']); // width, height
    }

    /**
     * Image Upload for Products
     *
     */
    private function imgUploadProducts(): void {
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
    private function initEac(): void {
        $EAC = new Eac();
        $EAC_ENGINE = $EAC->init(self::$resize_param, self::$resize_param_product);
        self::$idsx_real_parent_id = $EAC_ENGINE[0];
        self::$parent_id = $EAC_ENGINE[1];
    }

    /**
     * Select Data
     *
     */
    private function selectData(): void {

        self::$currencies_all = Db::connect()
                ->read(TABLE_CURRENCIES)
                ->selectAssoc('name, default_value, id')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$taxes_all = Db::connect()
                ->read(TABLE_TAXES)
                ->selectAssoc('name, id')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$units_all = Db::connect()
                ->read(TABLE_UNITS)
                ->selectAssoc('name, default_unit, id')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$length_all = Db::connect()
                ->read(TABLE_LENGTH)
                ->selectAssoc('name, default_length, id')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$weight_all = Db::connect()
                ->read(TABLE_WEIGHT)
                ->selectAssoc('name, default_weight, id')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$vendor_codes_all = Db::connect()
                ->read(TABLE_VENDOR_CODES)
                ->selectAssoc('name, default_vendor_code, id')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$manufacturers_all = Db::connect()
                ->read(TABLE_MANUFACTURERS)
                ->selectAssoc('name, id')
                ->where('language=', lang('#lang_all')[0])
                ->save();
    }

    /**
     * Prepared Data
     *
     */
    private function preparedData(): void {
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

            $attributes_category = Db::connect()
                    ->read(TABLE_CATEGORIES)
                    ->selectAssoc('attributes')
                    ->where('id=', self::$parent_id)
                    ->and('language=', lang('#lang_all')[0])
                    ->save();

            self::$attributes_category = json_encode($attributes_category[0]['attributes']);
        }

        self::$transfer = 0;
    }

    /**
     * Data
     *
     */
    private function data(): void {
        $search = '%' . Valid::inGET('search') . '%';
        if (Valid::inGET('search')) {

            $sql_data_cat_search = Db::connect()
                    ->read(TABLE_CATEGORIES)
                    ->selectAssoc('id')
                    ->where('name {{LIKE}}', $search)
                    ->and('language=', lang('#lang_all')[0])
                    ->orderByDesc('sort_category')
                    ->save();

            self::$sql_data_cat = [];

            foreach ($sql_data_cat_search as $sql_data_cat_search_val) {

                $search_val = Db::connect()
                        ->read(TABLE_CATEGORIES)
                        ->selectAssoc('*')
                        ->where('id=', $sql_data_cat_search_val['id'])
                        ->orderByDesc('sort_category')
                        ->save();

                foreach ($search_val as $cat_array) {
                    self::$sql_data_cat[] = $cat_array;
                }
            }
            self::$lines_cat = Func::filterData(self::$sql_data_cat, 'language', lang('#lang_all')[0]);

            $sql_data_prod_search = Db::connect()
                    ->read(TABLE_PRODUCTS)
                    ->selectAssoc('id')
                    ->where('name {{LIKE}}', $search)
                    ->and('language=', lang('#lang_all')[0])
                    ->or('description {{LIKE}}', $search)
                    ->and('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            self::$sql_data_prod = [];

            foreach ($sql_data_prod_search as $sql_data_prod_search_val) {

                $prod_search_val = Db::connect()
                        ->read(TABLE_PRODUCTS)
                        ->selectAssoc('*')
                        ->where('id=', $sql_data_prod_search_val['id'])
                        ->orderByDesc('id')
                        ->save();

                foreach ($prod_search_val as $prod_array) {
                    self::$sql_data_prod[] = $prod_array;
                }
            }
            self::$lines_prod = Func::filterData(self::$sql_data_prod, 'language', lang('#lang_all')[0]);
        } else {
            self::$sql_data_cat = Db::connect()
                    ->read(TABLE_CATEGORIES)
                    ->selectAssoc('*')
                    ->where('parent_id=', self::$parent_id)
                    ->orderByDesc('sort_category')
                    ->save();

            self::$lines_cat = Func::filterData(self::$sql_data_cat, 'language', lang('#lang_all')[0]);

            self::$sql_data_prod = Db::connect()
                    ->read(TABLE_PRODUCTS)
                    ->selectAssoc('*')
                    ->where('parent_id=', self::$parent_id)
                    ->orderByDesc('id')
                    ->save();

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
    private function modalCategories(): void {
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
                        $logo[$modal_id] = json_decode($sql_modal_cat['logo'], true);
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
    private function modalProducts(): void {
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
                        $logo_product[$modal_id_prod] = json_decode($sql_modal_prod['logo'], true);
                        $logo_general_product[$modal_id_prod] = $sql_modal_prod['logo_general'];
                        $attributes_product[$modal_id_prod] = json_decode($sql_modal_prod['attributes'], true);

                        if (self::$parent_id == 0) {
                            $attributes_data[$modal_id_prod] = json_encode(json_encode([]));
                        } else {

                            $attributes = Db::connect()
                                    ->read(TABLE_CATEGORIES)
                                    ->selectAssoc('attributes')
                                    ->where('id=', self::$parent_id)
                                    ->and('language=', lang('#lang_all')[0])
                                    ->save();

                            $attributes_data[$modal_id_prod] = json_encode($attributes[0]['attributes']);
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
    public static function statusCatClass(?string $class1, ?string $class2): string {

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
    public static function statusCatButton(?string $class1, ?string $class2): string {

        if (isset($_SESSION['buffer']['cat']) == true && in_array(self::$arr_merge['cat'][self::$start]['id'], $_SESSION['buffer']['cat']) == true) {
            return $class1;
        } elseif (self::$transfer == Settings::linesOnPage()) {
            return $class2;
        }
        return '';
    }

    /**
     * Class for products status
     *
     * @param string $class1 class
     * @param string $class2 class
     * @param string $class3 class
     * @return string
     */
    public static function statusProdClass(?string $class1, ?string $class2, ?string $class3 = null): string {
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
        }
        return $class2 . ' ' . $disabled;
    }

    /**
     * Class for discount
     *
     * @param string $class1 class
     * @param string $class2 class
     * @return string
     */
    public static function discountClass(?string $class1, ?string $class2): string {

        if (json_decode(Stock::$arr_merge['prod'][Stock::$start . 'a']['discount'], true)) {
            return $class1;
        }
        if (json_decode(Stock::$arr_merge['prod'][Stock::$start . 'a']['discount'], true) == 0) {
            return $class2;
        }
        return '';
    }

    /**
     * Data for sticker
     *
     * @param string $span1 span start
     * @param string $span2 span end
     * @return string
     */
    public static function stickerData(string $span1, string $span2): string {

        if (Stock::$arr_merge['prod'][Stock::$start . 'a']['sticker'] != '' && Stock::$arr_merge['prod'][Stock::$start . 'a']['sticker'] != NULL) {
            return $span1 . Stickers::$sticker_name[Stock::$arr_merge['prod'][Stock::$start . 'a']['sticker']] . $span2;
        }
        return '';
    }

    /**
     * Class for transfer
     *
     * @param string $class class
     * @return string
     */
    public static function transferClass(string $class): string {

        if (self::$transfer == Settings::linesOnPage()) {
            return $class;
        }
        return '';
    }

    /**
     * Tooltip data for product discounts
     *
     * @param mixed $discount Data on discounts in a line separated by commas
     * @return string
     */
    public static function productSaleTooltip(mixed $discount): string {

        $discount_json = json_decode($discount, true);
        $text = '';

        if (is_array($discount_json)) {
            foreach ($discount_json as $key => $id) {
                foreach ($id as $val_id) {

                    $module_name = Db::connect()
                            ->read(DB_PREFIX . 'modules_discount_' . $key)
                            ->selectValue('name')
                            ->where('language=', lang('#lang_all')[0])
                            ->and('id=', $val_id)
                            ->save();

                    $text .= lang('modules_discount_' . $key . '_name') . ': ' . $module_name . '<br>';
                }
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
    public static function discountLabel(string $span1, string $span2): string {

        if (self::productSaleTooltip(Stock::$arr_merge['prod'][Stock::$start . 'a']['discount']) != '') {
            return $span1;
        }
        return $span2;
    }

    /**
     * Text for categories
     *
     * @param string $class1 class
     * @param string $class2 class
     * @return array
     */
    public static function categoriesText(string $class1, string $class2): array {
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

    /**
     * Left button
     *
     * @return string (disabled style)
     */
    public static function leftButton(): string {
        $output = 'disabled';
        if (self::$start > 0) {
            $output = '';
        }
        return $output;
    }

    /**
     * Right button
     *
     * @return string (disabled style)
     */
    public static function rightButton(): string {
        $output = 'disabled';
        if (Pages::counterStock() < self::$count_lines_merge) {
            $output = '';
        }
        return $output;
    }

}
