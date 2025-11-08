<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Admin\HeaderMenu;

/**
 * Page Not Found
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class PageNotFound {

    public static $routing_parameter = 'page_not_found';
    public static $middleware = 'AdminAuthorize';
    public $title = 'title_page_not_found_index';

    /**
     * Constructor
     *
     */
    function __construct() {
        new HeaderMenu();
    }
}
