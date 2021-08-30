<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Install;

use eMarket\Core\{
    Settings,
    Valid
};

/**
 * Index
 *
 * @package Install
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Index {

    public static $default_language;

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
            self::$default_language = 'english';
        }

        if (Valid::inPOST('language')) {
            self::$default_language = Valid::inPOST('language');
        }
    }

    /**
     * PHP extension
     *
     * @param string $ext Extension
     * @return string bootstrap class
     */
    public function phpExtension($ext) {
        if (!extension_loaded($ext)) {
            return 'text-danger bi-x-lg';
        } else {
            return 'text-success bi-check-lg';
        }
    }

    /**
     * PHP version compare
     *
     * @return string bootstrap class
     */
    public function phpVersionCompare() {
        if (version_compare(PHP_VERSION, '7.3.0') >= 0) {
            return 'text-success bi-check-lg';
        } else {
            return 'text-danger bi-x-lg';
        }
    }

}
