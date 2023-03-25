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

    public static $routing_parameter = 'index';
    public $title = 'title_install';
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
    private function lang(): void {
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
    public function phpExtension(string $ext): string {
        if (!extension_loaded($ext)) {
            return 'text-danger bi-x-lg';
        }
        return 'text-success bi-check-lg';
    }

    /**
     * PHP ini_get compare
     *
     * @param string $ext Extension
     * @param string $val Value
     * @return string bootstrap class
     */
    public function phpIniGet(string $ext, string $val): string {
        if (ini_get($ext) < $val) {
            return 'text-danger bi-x-lg';
        }
        return 'text-success bi-check-lg';
    }

    /**
     * PHP version compare
     *
     * @return string bootstrap class
     */
    public function phpVersionCompare(): string {
        if (version_compare(PHP_VERSION, '8.2') >= 0) {
            return 'text-success bi-check-lg';
        }
        return 'text-danger bi-x-lg';
    }

}
