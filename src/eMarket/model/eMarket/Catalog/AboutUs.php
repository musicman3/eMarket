<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use Cruder\Db;

/**
 * AboutUs
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class AboutUs {

    public static $routing_parameter = 'about_us';
    public static $middleware = '';
    public $title = 'title_about_us_index';
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

        $data = Db::connect()
                ->read(TABLE_ABOUT_US)
                ->selectAssoc('*')
                ->save();

        for ($x = 0; $x < count(lang('#lang_all')); $x++) {
            if (isset($data[$x]['language']) && $data[$x]['language'] == lang('#lang_all')[0]) {
                self::$description = $data[$x]['description'];
            }
            if (isset($data[$x]['status']) && $data[$x]['status'] == 0) {
                header('Location: ?route=page_not_found');
                exit;
            }
        }
    }
}
