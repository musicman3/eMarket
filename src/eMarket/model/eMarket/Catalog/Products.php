<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Func,
    DataBuffer,
    Products as ProductsCore,
    Valid,
    Tabs
};

/**
 * Products
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Products {

    public static $routing_parameter = 'products';
    public $title;
    public static $dimension_name;
    public static $dimensions = FALSE;
    public static $products = FALSE;
    public static $manufacturer = FALSE;
    public static $vendor_code = FALSE;
    public static $vendor_code_value = FALSE;
    public static $weight = FALSE;
    public static $weight_value = FALSE;
    public static $images = FALSE;
    public static $attributes_data = FALSE;
    public static $tabs_data = [];

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->title();
        $this->data();
        $this->dimensions();
        $this->manufacturer();
        $this->vendorCode();
        $this->weight();
        $this->images();
        $this->attributes();
        $this->tabs();
    }

    /**
     * Title
     *
     */
    private function title(): void {
        $product_data = ProductsCore::productData(Valid::inGET('id'));
        if ($product_data['tags'] != NULL && $product_data['tags'] != '') {
            $title = $product_data['tags'];
        } else {
            $title = $product_data['name'];
        }
        $this->title = lang('title_products_index') . ': ' . $title;
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$products = ProductsCore::productData(Valid::inGET('id'));
    }

    /**
     * Dimensions
     *
     */
    private function dimensions(): void {

        self::$dimension_name = ProductsCore::length(self::$products['dimension'])['code'];
        self::$dimensions = '';
        $dimension_marker = 0;

        if (self::$products['length'] != NULL && self::$products['length'] != FALSE) {
            self::$dimensions .= self::$products['length'] . ' (' . lang('product_dimension_length') . ')';
            $dimension_marker++;
        }

        if (self::$products['width'] != NULL && self::$products['width'] != FALSE) {
            if ($dimension_marker > 0) {
                self::$dimensions .= ' x ' . self::$products['width'] . ' (' . lang('product_dimension_width') . ')';
                $dimension_marker++;
            } else {
                self::$dimensions .= self::$products['width'] . ' (' . lang('product_dimension_width') . ')';
                $dimension_marker++;
            }
        }

        if (self::$products['height'] != NULL && self::$products['height'] != FALSE) {
            if ($dimension_marker > 0) {
                self::$dimensions .= ' x ' . self::$products['height'] . ' (' . lang('product_dimension_height') . ')';
                $dimension_marker++;
            } else {
                self::$dimensions .= self::$products['height'] . ' (' . lang('product_dimension_height') . ')';
                $dimension_marker++;
            }
        }
    }

    /**
     * Manufacturer
     *
     */
    public function manufacturer(): void {
        self::$manufacturer = ProductsCore::manufacturer(self::$products['manufacturer'])['name'];
    }

    /**
     * Vendor Code
     *
     */
    public function vendorCode(): void {
        self::$vendor_code = ProductsCore::vendorCode(self::$products['vendor_code'])['name'];

        if (self::$vendor_code != NULL && self::$vendor_code != FALSE) {
            self::$vendor_code_value = self::$products['vendor_code_value'];
        }
    }

    /**
     * Weight
     *
     */
    private function weight(): void {
        self::$weight = ProductsCore::weight(self::$products['weight'])['code'];

        if (self::$weight != NULL && self::$weight != FALSE) {
            self::$weight_value = self::$products['weight_value'];
        }
    }

    /**
     * Images
     *
     */
    private function images(): void {
        self::$images = Func::deleteValInArray(json_decode(self::$products['logo'], true), [self::$products['logo_general']]);
    }

    /**
     * Attributes
     *
     */
    private function attributes(): void {
        $categories_data = ProductsCore::categoryData(Valid::inGET('category_id'));
        if (Valid::inGET('category_id') == 0) {
            self::$attributes_data = json_encode([]);
        } else {
            self::$attributes_data = json_encode($categories_data['attributes']);
        }
    }

    /**
     * Tabs
     *
     */
    private function tabs(): void {
        Tabs::loadData();

        $DataBuffer = new DataBuffer();
        $modules_data = $DataBuffer->load('tabs');

        $interface_data = [];
        if (is_array($modules_data)) {
            foreach ($modules_data as $data) {

                // INTERFACE
                $interface = [
                    'chanel_module_name' => $data['chanel_module_name'],
                    'chanel_name' => $data['chanel_name']
                ];

                array_push($interface_data, $interface);
            }
        }
        self::$tabs_data = $interface_data;
    }

}
