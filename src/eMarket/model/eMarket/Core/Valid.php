<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

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
    public static $test_post_json = FALSE;
    public static $test_post = FALSE;
    public static $test_get = FALSE;
    public static $test_server = FALSE;
    public static $test_cookie = FALSE;

    /**
     * POST validation
     *
     * @param string $input Input data
     * @return mixed
     */
    public static function inPOST(?string $input): mixed {
        if (self::$test_post != FALSE && isset(self::$test_post[$input])) {
            return self::$test_post[$input];
        }
        if (filter_input(INPUT_POST, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE && self::$demo_mode == FALSE) {
            if (isset($_POST[$input])) {
                return $_POST[$input];
            }
        }
        return FALSE;
    }

    /**
     * Check for POST request 
     *
     * @return bool
     */
    public static function isPOST(): bool {
        if (isset($_POST) && count($_POST) > 0) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * GET validation
     *
     * @param string $input Input data
     * @return mixed
     */
    public static function inGET(?string $input): mixed {
        if (self::$test_get != FALSE && isset(self::$test_get[$input])) {
            return self::$test_get[$input];
        }
        if (filter_input(INPUT_GET, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
            if (isset($_GET[$input])) {
                return $_GET[$input];
            }
        }
        return FALSE;
    }

    /**
     * $_SERVER validation
     *
     * @param string $input Input data
     * @return mixed
     */
    public static function inSERVER(?string $input): mixed {
        if (self::$test_server != FALSE && isset(self::$test_server[$input])) {
            return self::$test_server[$input];
        }
        if (filter_input(INPUT_SERVER, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
            if (isset($_SERVER[$input])) {
                return $_SERVER[$input];
            }
        }
        return FALSE;
    }

    /**
     * $_COOKIE validation
     *
     * @param string $input Input data
     * @return mixed
     */
    public static function inCOOKIE(?string $input): mixed {
        if (self::$test_cookie != FALSE && isset(self::$test_cookie[$input])) {
            return self::$test_cookie[$input];
        }
        if (filter_input(INPUT_COOKIE, $input, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FORCE_ARRAY) == TRUE) {
            if (isset($_COOKIE[$input])) {
                return $_COOKIE[$input];
            }
        }
        return FALSE;
    }

    /**
     * JSON POST validation
     *
     * @param string $input Input data
     * @return mixed
     */
    public static function inPostJson(?string $input): mixed {
        if (self::$test_post_json != FALSE && isset(self::$test_post_json[$input])) {
            return self::$test_post_json[$input];
        }
        $postData = htmlspecialchars(file_get_contents('php://input'), ENT_NOQUOTES);
        $data = json_decode($postData, true);
        if (is_string($postData) && is_array($data) && (json_last_error() == JSON_ERROR_NONE) && self::$demo_mode == FALSE) {
            if (isset($data[$input])) {
                return $data[$input];
            }
        }
        return FALSE;
    }

    /**
     * Check for jsonPOST request 
     *
     * @return bool
     */
    public static function isPostJson(): bool {
        $postData = htmlspecialchars(file_get_contents('php://input'), ENT_NOQUOTES);
        $data = json_decode($postData, true);
        if (is_string($postData) && is_array($data) && (json_last_error() == JSON_ERROR_NONE) && self::$demo_mode == FALSE) {
            return TRUE;
        }
        return FALSE;
    }

}
