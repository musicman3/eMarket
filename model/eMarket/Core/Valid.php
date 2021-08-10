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

    public static $demo_mode = FALSE;

    /**
     * POST validation
     *
     * @param array|string $input Input data
     * @return array|string
     */
    public static function inPOST($input) {
        if (filter_input(INPUT_POST, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE && self::$demo_mode == FALSE) {
            if (isset($_POST[$input])) {
                return $_POST[$input];
            } else {
                return FALSE;
            }
        }
    }

    /**
     * GET validation
     *
     * @param array|string $input Input data
     * @return array|string
     */
    public static function inGET($input) {
        if (filter_input(INPUT_GET, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
            if (isset($_GET[$input])) {
                return $_GET[$input];
            } else {
                return FALSE;
            }
        }
    }

    /**
     * $_SERVER validation
     *
     * @param string $input Input data
     * @return string
     */
    public static function inSERVER($input) {
        if (filter_input(INPUT_SERVER, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
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
        if (filter_input(INPUT_COOKIE, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
            return (isset($_COOKIE[$input])) ? $_COOKIE[$input] : null;
        }
    }

    /**
     * JSON POST validation
     *
     * @param string $input Input data
     * @return array
     */
    public static function inPostJson($input) {
        $postData = file_get_contents('php://input');
        if (is_string($postData) && is_array(json_decode($postData, true)) && (json_last_error() == JSON_ERROR_NONE) && self::$demo_mode == FALSE) {
            $data = json_decode($postData, true);
            if (isset($data[$input])) {
                return htmlspecialchars($data[$input]);
            }
        }
        return FALSE;
    }

}
