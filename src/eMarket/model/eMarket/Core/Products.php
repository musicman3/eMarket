<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Cache,
    Clock\SystemClock,
    Ecb,
    DataBuffer
};
use Cruder\Db;

/**
 * Products
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Products {

    public static $sticker_data = FALSE;
    public static $product_data = FALSE;
    public static $category_data = [];
    private static $manufacturer = FALSE;
    private static $vendor_codes = FALSE;
    private static $weight = FALSE;
    private static $length = FALSE;

    /**
     * New products data
     *
     * @param string|int|null $count Number of new products
     * @return mixed New products data
     */
    public static function newProducts(string $count = ''): mixed {

        $Cache = new Cache();
        $Cache->cache_name = 'core.new_products';

        if (!$Cache->isHit()) {

            $Cache->data = Db::connect()
                    ->read(TABLE_PRODUCTS)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->and('status=', 1)
                    ->orderByDesc('id')
                    ->limit($count)
                    ->save();

            return $Cache->save($Cache->data);
        }

        return $Cache->cache_item->get();
    }

    /**
     * Product data
     *
     * @param string|int $id Product id
     * @param string $language Language
     * @return array
     */
    public static function productData(string|int $id, ?string $language = null): array {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }

        $Cache = new Cache();
        $Cache->cache_name = 'core.products_' . $id;

        if (!$Cache->isHit()) {

            $Cache->data = Db::connect()
                            ->read(TABLE_PRODUCTS)
                            ->selectAssoc('*')
                            ->where('id=', $id)
                            ->and('language=', $language)
                            ->and('status=', 1)
                            ->save()[0];

            self::$product_data = $Cache->data;
            return $Cache->save($Cache->data);
        }

        self::$product_data = $Cache->cache_item->get();
        return $Cache->cache_item->get();
    }

    /**
     * Categury data
     *
     * @param string|int $id Category id
     * @param string $language Language
     * @return array
     */
    public static function categoryData(string|int $id, ?string $language = null): array {

        if (count(self::$category_data) == 0) {
            if ($language == null) {
                $language = lang('#lang_all')[0];
            }

            self::$category_data = Db::connect()
                            ->read(TABLE_CATEGORIES)
                            ->selectAssoc('*')
                            ->where('language=', $language)
                            ->and('id=', $id)
                            ->save()[0];

            return self::$category_data;
        }

        return self::$category_data;
    }

    /**
     * Manufacturer data
     *
     * @param string|int $id Id
     * @return array|bool 
     */
    public static function manufacturer(string|int $id): array|bool {

        if (self::$manufacturer == FALSE) {

            self::$manufacturer = Db::connect()
                    ->read(TABLE_MANUFACTURERS)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->save();
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
     * @param string|int $id Id
     * @return array|bool
     */
    public static function vendorCode(string|int $id): array|bool {

        if (self::$vendor_codes == FALSE) {

            self::$vendor_codes = Db::connect()
                    ->read(TABLE_VENDOR_CODES)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->save();
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
     * @param string|int $id Id
     * @return array|bool
     */
    public static function weight(string|int $id): array|bool {

        if (self::$weight == FALSE) {

            self::$weight = Db::connect()
                    ->read(TABLE_WEIGHT)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->save();
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
     * @param string|int $id Id
     * @return array|bool
     */
    public static function length(string|int $id): array|bool {

        if (self::$length == FALSE) {

            self::$length = Db::connect()
                    ->read(TABLE_LENGTH)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->save();
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
    public static function inStock(?string $date_available, int|string $quantity): array {
        if ($date_available != NULL && $date_available != FALSE && SystemClock::getUnixTime($date_available) > SystemClock::nowUnixTime()) {
            $date_available_marker = 'false';
            $date_available_text = lang('product_in_stock_from') . ' ' . SystemClock::getDate($date_available);
        } elseif ($quantity != NULL && $quantity <= 0) {
            $date_available_text = lang('product_out_of_stock');
            $date_available_marker = 'true';
        } else {
            $date_available_marker = 'true';
            $date_available_text = lang('product_in_stock');
        }

        $output = [];

        if ($date_available_marker == 'false') {
            array_push($output, ['badge bg-warning', $date_available_text]);
            return $output;
        } elseif ($quantity != NULL && $quantity <= 0) {
            array_push($output, ['badge bg-danger', $date_available_text]);
            return $output;
        } else {
            array_push($output, ['badge bg-success', $date_available_text]);
            return $output;
        }
        return $output;
    }

    /**
     * Stickers
     * 
     * @param array $input Input data
     * @param string $class Bootstrap class
     * @param string $class2 Bootstrap class
     * @return string
     */
    public static function stickers(array $input, ?string $class = null, ?string $class2 = null): array {

        if ($class == null) {
            $class = 'danger';
        }
        if ($class2 == null) {
            $class2 = 'success';
        }
        if (self::$sticker_data == false) {

            self::$sticker_data = Db::connect()
                    ->read(TABLE_STICKERS)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->save();
        }
        $sticker_name = [];
        foreach (self::$sticker_data as $val) {
            $sticker_name[$val['id']] = $val['name'];
        }

        $DataBuffer = new DataBuffer();
        Ecb::discountHandler($input);
        $discount_handler = $DataBuffer->load('discountHandler', 'data', 'discounts_data');

        $discount_total_sale = 0;
        foreach ($discount_handler as $data) {
            if ($data['discounts'] != 'false') {
                foreach ($data['discounts'] as $total_sale) {
                    $discount_total_sale = $discount_total_sale + $total_sale;
                }
            }
        }

        $stickers = [];

        if (isset($discount_total_sale) && $discount_total_sale > 0 && $input['sticker'] != '' && $input['sticker'] != NULL) {

            array_push($stickers, [$class, '- ' . $discount_total_sale . '%']);
            array_push($stickers, [$class2, $sticker_name[$input['sticker']]]);

            return $stickers;
        }

        if ($input['sticker'] != '' && $input['sticker'] != NULL) {

            array_push($stickers, [$class2, $sticker_name[$input['sticker']]]);

            return $stickers;
        }

        if (isset($discount_total_sale) && $discount_total_sale > 0) {

            array_push($stickers, [$class, '- ' . $discount_total_sale . '%']);

            return $stickers;
        }
        return [];
    }

}
