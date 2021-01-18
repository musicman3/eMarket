<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use \eMarket\Core\{
    Pdo,
    Valid
};

/**
 * Modules/Edit
 *
 * @package Admin
 * @author eMarket
 * 
 */
class ModulesEdit {

    public static $switch_active = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->switch_active();
    }

    /**
     * Bootstrap class helper
     *
     */
    public function switch_active() {
        $active = Pdo::getCellFalse("SELECT active FROM " . TABLE_MODULES . " WHERE type=? AND name=?", [
                    Valid::inGET('type'), Valid::inGET('name')])[0];

        if ($active == 1) {
            self::$switch_active = 'checked';
        } else {
            self::$switch_active = '';
        }
    }

}
