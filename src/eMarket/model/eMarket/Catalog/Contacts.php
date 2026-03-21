<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use Cruder\Db;

/**
 * Contacts
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Contacts {

    public static $routing_parameter = 'contacts';
    public static $middleware = '';
    public $title = 'title_contacts_index';
    public static $description = '';

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->data();
    }

    /**
     * Data
     *
     */
    public static function data(): void {

        $description = Db::connect()
                ->read(TABLE_CONTACTS)
                ->selectAssoc('*')
                ->save();

        for ($x = 0; $x < count(lang('#lang_all')); $x++) {
            if (isset($description[$x]['language']) && $description[$x]['language'] == lang('#lang_all')[0]) {
                self::$description = $description[$x]['description'];
            }
        }
    }
}
