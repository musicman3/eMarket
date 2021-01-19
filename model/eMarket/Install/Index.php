<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Install;

use \eMarket\Core\{
    Settings,
    Valid
};

/**
 * Index
 *
 * @package Install
 * @author eMarket
 * 
 */
class Index {

    public static $DEFAULT_LANGUAGE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->lang();
    }

    /**
     * Default language
     *
     */
    public function lang() {
        if (!Valid::inPOST('language') && Settings::path() == 'install') {
            self::$DEFAULT_LANGUAGE = 'english';
        }

        if (Valid::inPOST('language')) {
            self::$DEFAULT_LANGUAGE = Valid::inPOST('language');
        }
    }

}
