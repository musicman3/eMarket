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
    public static $post_json_simulator = FALSE;
    public static $post_simulator = FALSE;
    public static $get_simulator = FALSE;
    public static $server_simulator = FALSE;
    public static $cookie_simulator = FALSE;

    /**
     * Request simulator
     *
     * @param string $type Data type (json|post|get|server|cookie)
     * @param mixed $data Data
     */
    public static function requestSimulator(string $type, mixed $data): void {
        if ($type == 'json' && !self::$post_json_simulator) {
            self::$post_json_simulator = $data;
        }
        if ($type == 'post' && !self::$post_simulator) {
            self::$post_simulator = $data;
        }
        if ($type == 'get' && !self::$get_simulator) {
            self::$get_simulator = $data;
        }
        if ($type == 'server' && !self::$server_simulator) {
            self::$server_simulator = $data;
        }
        if ($type == 'cookie' && !self::$cookie_simulator) {
            self::$cookie_simulator = $data;
        }
    }

    /**
     * Close Request simulator
     *
     */
    public static function closeRequestSimulator(): void {
        self::$post_json_simulator = FALSE;
        self::$post_simulator = FALSE;
        self::$get_simulator = FALSE;
        self::$server_simulator = FALSE;
        self::$cookie_simulator = FALSE;
    }

    /**
     * POST validation
     *
     * @param string $input Input data
     * @return mixed
     */
    public static function inPOST(?string $input): mixed {
        if (self::$post_simulator != FALSE && isset(self::$post_simulator[$input])) {
            return self::$post_simulator[$input];
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
        if (self::$get_simulator != FALSE && isset(self::$get_simulator[$input])) {
            return self::$get_simulator[$input];
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
        if (self::$server_simulator != FALSE && isset(self::$server_simulator[$input])) {
            return self::$server_simulator[$input];
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
        if (self::$cookie_simulator != FALSE && isset(self::$cookie_simulator[$input])) {
            return self::$cookie_simulator[$input];
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
        if (self::$post_json_simulator != FALSE && isset(self::$post_json_simulator[$input])) {
            return self::$post_json_simulator[$input];
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
