<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Valid,
    Tree
};
use Cruder\Db;

/**
 * Index
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Categories {

    public static $categories_and_breadcrumb;
    public static $index_data;
    public static $listing_data;

    /**
     * Data
     *
     * @return obj
     */
    public static function data(): void {

        $sql = Db::connect()
                ->read(TABLE_CATEGORIES)
                ->selectObj('id, name, status, parent_id')
                ->where('language=', lang('#lang_all')[0])
                ->and('status=', 1)
                ->orderByDesc('sort_category')
                ->save();

        self::$categories_and_breadcrumb = Tree::categories($sql, Valid::inGET('category_id'));
    }

    /**
     * Index Data
     *
     * @return string url
     */
    public static function indexData(): void {

        self::$index_data = Db::connect()
                ->read(TABLE_CATEGORIES)
                ->selectIndex('id, name, logo_general, status')
                ->where('language=', lang('#lang_all')[0])
                ->and('parent_id=', 0)
                ->and('status=', 1)
                ->orderByDesc('sort_category')
                ->save();
    }

    /**
     * Listing Data
     *
     * @return string url
     */
    public static function listingData(): void {

        self::$listing_data = Db::connect()
                ->read(TABLE_CATEGORIES)
                ->selectIndex('id, name, logo_general, status')
                ->where('language=', lang('#lang_all')[0])
                ->and('parent_id=', Valid::inGET('category_id'))
                ->and('status=', 1)
                ->orderByDesc('sort_category')
                ->save();
    }

}
