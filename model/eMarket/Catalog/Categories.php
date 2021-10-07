<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Pdo,
    Valid,
    Tree
};

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
        $sql = Pdo::getObj("SELECT id, name, status, parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? AND status=? ORDER BY sort_category DESC", [lang('#lang_all')[0], 1]);
        self::$categories_and_breadcrumb = Tree::categories($sql, Valid::inGET('category_id'));
    }

    /**
     * Index Data
     *
     * @return string url
     */
    public static function indexData(): void {
        self::$index_data = Pdo::getIndex("SELECT id, name, logo_general, status FROM " . TABLE_CATEGORIES . " WHERE language=? AND parent_id=? AND status=? ORDER BY sort_category DESC", [lang('#lang_all')[0], 0, 1]);
    }

    /**
     * Listing Data
     *
     * @return string url
     */
    public static function listingData(): void {
        self::$listing_data = Pdo::getIndex("SELECT id, name, logo_general, status FROM " . TABLE_CATEGORIES . " WHERE language=? AND parent_id=? AND status=? ORDER BY sort_category DESC", [lang('#lang_all')[0], Valid::inGET('category_id'), 1]);
    }

}
