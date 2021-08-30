<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Validation
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Valid {

    public static $demo_mode = FALSE;

    /**
     * POST validation
     *
     * @param array|string $input Input data
     * @return array|string|bool
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
     * Check for POST request 
     *
     * @return bool
     */
    public static function isPOST() {
        if (isset($_POST) && count($_POST) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * GET validation
     *
     * @param array|string $input Input data
     * @return array|string|bool
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
     * @return array|string|bool
     */
    public static function inSERVER($input) {
        if (filter_input(INPUT_SERVER, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
            if (isset($_SERVER[$input])) {
                return $_SERVER[$input];
            } else {
                return FALSE;
            }
        }
    }

    /**
     * $_COOKIE validation
     *
     * @param string $input Input data
     * @return string|bool
     */
    public static function inCOOKIE($input) {
        if (filter_input(INPUT_COOKIE, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
            if (isset($_COOKIE[$input])) {
                return $_COOKIE[$input];
            } else {
                return FALSE;
            }
        }
    }

    /**
     * JSON POST validation
     *
     * @param string $input Input data
     * @return array|string|bool
     */
    public static function inPostJson($input) {
        $postData = htmlspecialchars(file_get_contents('php://input'), ENT_NOQUOTES);
        $data = json_decode($postData, true);
        if (is_string($postData) && is_array($data) && (json_last_error() == JSON_ERROR_NONE) && self::$demo_mode == FALSE) {
            if (isset($data[$input])) {
                return $data[$input];
            }
        }
        return FALSE;
    }

}
