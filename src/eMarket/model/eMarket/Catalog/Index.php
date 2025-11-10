<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Products as ProductsCore,
    Settings as SettingsCore
};
use eMarket\Catalog\{
    Listing
};
use R2D2\R2\Valid;

/**
 * Index
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Index {

    public static $routing_parameter = 'catalog';
    public static $middleware = 'CurrencyCheck, CatalogAuthorize';
    public $title = 'title_catalog_index';

    /**
     * Constructor
     *
     */
    function __construct() {
        
    }

    /**
     * Keywords
     *
     * @return mixed
     */
    public static function keywordsCatalog(): mixed {

        $keywords = '';
        $route = Valid::inGET('route');

        if (is_bool($route) || is_null($route)) {
            $route = '';
        }

        if (basename($route) == 'products' && SettingsCore::path() == 'catalog') {
            $product_data = ProductsCore::productData(Valid::inGET('id'));
            if ($product_data != false && $product_data ['keyword'] != NULL && $product_data ['keyword'] != '') {
                $keywords = $product_data ['keyword'];
            } else {
                $keywords = '';
            }
        }

        if (basename($route) == 'listing' && SettingsCore::path() == 'catalog') {
            $catalog_keyword = Listing::$categories_keyword;
            if ($catalog_keyword != NULL && $catalog_keyword != '') {
                $keywords = $catalog_keyword;
            } else {
                $keywords = '';
            }
        }

        return $keywords;
    }
}
