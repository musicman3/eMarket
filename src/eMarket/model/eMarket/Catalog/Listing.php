<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Ecb,
    Pages,
    Products,
    Valid
};
use Cruder\Db;

/**
 * Listing
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Listing {

    public static $routing_parameter = 'listing';
    public $title = 'title_listing_index';
    public static $checked_stock = '';
    public $sort_parameter = '';
    public static $sort_name;
    public static $sort_flag;
    public static $categories_name;
    public static $categories_description;
    public static $categories_keyword;
    public static $categories_tags;
    public static $categories_logo;
    public static $product_edit;
    public static $sql_data;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->title();
        $this->data();
        $this->modal();
    }

    /**
     * Title
     *
     */
    private function title(): void {
        $title = Db::connect()
                ->read(TABLE_CATEGORIES)
                ->selectAssoc('*')
                ->where('language=', lang('#lang_all')[0])
                ->and('id=', Valid::inGET('category_id'))
                ->save();
        if (isset($title[0])) {
            if ($title[0]['tags'] != null && $title[0]['tags'] != '') {
                $this->title = lang('title_listing_index') . ': ' . $title[0]['tags'];
            } else {
                $this->title = lang('title_listing_index') . ': ' . $title[0]['name'];
            }
        } else {
            $this->title = lang('title_listing_index') . ': ' . lang('page_not_found_title');
        }
    }

    /**
     * Sorting data
     *
     * @param object $sql_data sql_data object
     */
    private function sorting(object $sql_data): mixed {
        self::$sort_flag = 'off';

        if (Valid::inGET('change') == 'on' OR !Valid::inGET('change')) {
            self::$checked_stock = ' checked';
        }

        if (!Valid::inGET('sort')) {
            self::$sort_flag = 'on';
        }

        if (!Valid::inGET('sort') OR Valid::inGET('sort') == 'default') {
            self::$sort_name = lang('listing_sort_by_default');
            return $sql_data->orderByDesc('id');
        }
        if (Valid::inGET('sort') == 'name') {
            self::$sort_name = lang('listing_sort_by_name');
            return $sql_data->orderByAsc('name');
        }
        if (Valid::inGET('sort') == 'up') {
            self::$sort_name = lang('listing_sort_by_price_asc');
            return $sql_data->orderByAsc('price');
        }
        if (Valid::inGET('sort') == 'down') {
            self::$sort_name = lang('listing_sort_by_price_desc');
            return $sql_data->orderByDesc('price');
        }
    }

    /**
     * Characteristics Data
     *
     * @return array
     */
    public static function getCharData(): array {

        $output = [];

        if (Pages::$table['line']['vendor_code'] != NULL && Pages::$table['line']['vendor_code'] != FALSE && Pages::$table['line']['vendor_code_value'] != NULL && Pages::$table['line']['vendor_code_value'] != FALSE) {
            $output['vendor_code'] = [
                'label' => Products::vendorCode(Pages::$table['line']['vendor_code'])['name'] . ':',
                'text' => Pages::$table['line']['vendor_code_value']
            ];
        }
        if (Products::manufacturer(Pages::$table['line']['manufacturer'])['name'] != NULL && Products::manufacturer(Pages::$table['line']['manufacturer'])['name'] != FALSE) {
            $output['manufacturer'] = [
                'label' => lang('product_manufacturer'),
                'text' => Products::manufacturer(Pages::$table['line']['manufacturer'])['name']
            ];
        }
        if (Pages::$table['line']['model'] != NULL && Pages::$table['line']['model'] != FALSE) {
            $output['model'] = [
                'label' => lang('product_model'),
                'text' => Pages::$table['line']['model']
            ];
        }

        return $output;
    }

    /**
     * Data
     *
     */
    private function data(): void {
        if (Valid::inGET('search')) {
            $search = '%' . Valid::inGET('search') . '%';

            $sql_data = Db::connect()
                    ->read(TABLE_PRODUCTS)
                    ->selectAssoc('*')
                    ->where('name {{LIKE}}', $search)
                    ->and('language=', lang('#lang_all')[0])
                    ->and('status=', 1)
                    ->and('quantity>', 0)
                    ->or('description {{LIKE}}', $search)
                    ->and('language=', lang('#lang_all')[0])
                    ->and('status=', 1)
                    ->and('quantity>', 0);
        } elseif (Valid::inGET('change') == 'off') {
            $sql_data = Db::connect()
                    ->read(TABLE_PRODUCTS)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->and('parent_id=', Valid::inGET('category_id'))
                    ->and('status=', 1)
                    ->and('quantity>', 0);
        } else {
            $sql_data = Db::connect()
                    ->read(TABLE_PRODUCTS)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->and('parent_id=', Valid::inGET('category_id'))
                    ->and('status=', 1);
        }

        self::$sql_data = $this->sorting($sql_data)->save();

        Pages::data(self::$sql_data);

        if (Valid::inGET('category_id') && Products::categoryData(Valid::inGET('category_id')) != false) {
            self::$categories_name = Products::categoryData(Valid::inGET('category_id'))['name'];
            self::$categories_description = Products::categoryData(Valid::inGET('category_id'))['description'];
            self::$categories_keyword = Products::categoryData(Valid::inGET('category_id'))['keyword'];
            self::$categories_tags = Products::categoryData(Valid::inGET('category_id'))['tags'];
            self::$categories_logo = Products::categoryData(Valid::inGET('category_id'))['logo_general'];
        }
    }

    /**
     * Modal
     *
     */
    private function modal(): void {
        self::$product_edit = json_encode([]);
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(self::$sql_data[$i]['id']) == TRUE) {

                $modal_id = self::$sql_data[$i]['id'];

                $query = Db::connect()
                                ->read(TABLE_PRODUCTS)
                                ->selectAssoc('*')
                                ->where('id=', $modal_id)
                                ->and('language=', lang('#lang_all')[0])
                                ->save()[0];

                $product_temp[$modal_id] = $query;
                $product_temp[$modal_id]['price_formated'] = Ecb::priceInterface($query, 2);

                self::$product_edit = json_encode($product_temp);
            }
        }
    }
}
