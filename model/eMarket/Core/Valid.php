<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Validation
 *
 * @package Valid
 * @author eMarket
 * 
 */
class Valid {

    /**
     * POST validation
     *
     * @param array|string $input Input data
     * @return array|string
     */
    public static function inPOST($input) {
        if (filter_input(INPUT_POST, $input, FILTER_DEFAULT, FILTER_FORCE_ARRAY) == TRUE) {
            return (isset($_POST[$input])) ? $_POST[$input] : null;
        }
    }

    /**
     * GET validation
     *
     * @param array|string $input Input data
     * @return array|string
     */
    public static function inGET($input) {
        if (filter_input(INPUT_GET, $input, FILTER_DEFAULT, FILTER_FORCE_ARRAY) == TRUE) {
            return (isset($_GET[$input])) ? $_GET[$input] : null;
        }
    }

    /**
     * $_SERVER validation
     *
     * @param string $input Input data
     * @return string
     */
    public static function inSERVER($input) {
        if (filter_input(INPUT_SERVER, $input, FILTER_DEFAULT, FILTER_FORCE_ARRAY) == TRUE) {
            return (isset($_SERVER[$input])) ? $_SERVER[$input] : null;
        }
    }

    /**
     * $_COOKIE validation
     *
     * @param string $input Input data
     * @return string
     */
    public static function inCOOKIE($input) {
        if (filter_input(INPUT_COOKIE, $input) == TRUE) {
            return (isset($_COOKIE[$input])) ? $_COOKIE[$input] : null;
        }
    }

}
