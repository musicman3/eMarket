<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Pages,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Dashboard
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Dashboard {

    /**
     * Constructor
     *
     */
    function __construct() {
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu() {
        HeaderMenu::$menu[HeaderMenu::$menu_market][] = ['?route=dashboard', 'bi-columns', lang('menu_dashboard'), '', 'false'];
    }


}
