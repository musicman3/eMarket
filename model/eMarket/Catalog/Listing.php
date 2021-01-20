<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use \eMarket\Core\{
    Ecb,
    Pages,
    Pdo,
    Products,
    Valid
};

/**
 * Listing
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class Listing {

    public static $checked_stock = FALSE;
    public static $sort_parameter = FALSE;
    public static $sort_name;
    public static $sort_flag;
    public static $categories_name;
    public static $product_edit;
    public static $lines;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->initData();
        $this->data();
        $this->modal();
    }

    /**
     * Init Data
     *
     */
    public function initData() {
        if (Valid::inGET('change') == 'on' OR!Valid::inGET('change')) {
            self::$checked_stock = ' checked';
            $qnt_flag = '';
        } else {
            self::$checked_stock = '';
            $qnt_flag = 'AND quantity>0 ';
        }
        if (!Valid::inGET('sort')) {
            self::$sort_flag = 'on';
        } else {
            self::$sort_flag = 'off';
        }

        if (!Valid::inGET('sort') OR Valid::inGET('sort') == 'default') {
            self::$sort_parameter = $qnt_flag . 'ORDER BY id DESC';
            self::$sort_name = lang('listing_sort_by_default');
        }
        if (Valid::inGET('sort') == 'name') {
            self::$sort_parameter = $qnt_flag . 'ORDER BY name ASC';
            self::$sort_name = lang('listing_sort_by_name');
        }
        if (Valid::inGET('sort') == 'up') {
            self::$sort_parameter = $qnt_flag . 'ORDER BY price ASC';
            self::$sort_name = lang('listing_sort_by_price_asc');
        }
        if (Valid::inGET('sort') == 'down') {
            self::$sort_parameter = $qnt_flag . 'ORDER BY price DESC';
            self::$sort_name = lang('listing_sort_by_price_desc');
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        if (Valid::inGET('search')) {
            $search = '%' . Valid::inGET('search') . '%';
            self::$lines = Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE (name LIKE? OR description LIKE?) AND language=? AND status=? " . self::$sort_parameter, [
                        $search, $search, lang('#lang_all')[0], 1
            ]);
        } else {
            self::$lines = Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=? AND status=? " . self::$sort_parameter, [
                        lang('#lang_all')[0], Valid::inGET('category_id'), 1
            ]);
        }
        Pages::data(self::$lines);
        if (Valid::inGET('category_id')) {
            self::$categories_name = Products::categoryData(Valid::inGET('category_id'))['name'];
        }
    }

    /**
     * Modal
     *
     */
    public function modal() {
        self::$product_edit = json_encode([]);
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(self::$lines[$i]['id']) == TRUE) {

                $modal_id = self::$lines[$i]['id'];

                $query = Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[0]])[0];
                $product_temp[$modal_id] = $query;
                $product_temp[$modal_id]['price_formated'] = Ecb::priceInterface($query, 2);

                self::$product_edit = json_encode($product_temp);
            }
        }
    }

}
