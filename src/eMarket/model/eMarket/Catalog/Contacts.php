<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Settings
};

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
    public static $description = [];

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

        $basic_settings = Settings::basicSettings();
        $other = json_decode($basic_settings['other'], true);
        if (isset($other['store_contacts_' . lang('#lang_all')[0]])) {
            self::$description = $other['store_contacts_' . lang('#lang_all')[0]];
        } else {
            self::$description = '';
        }
    }
}
