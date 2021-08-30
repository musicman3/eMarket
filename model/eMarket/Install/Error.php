<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Install;

use eMarket\Core\{
    Valid
};

/**
 * Error
 *
 * @package Install
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Error {

    public static $message;
    public static $error_message;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->data();
    }

    /**
     * Data
     *
     */
    public function data() {
        if (Valid::inGET('file_configure_not_found')) {
            self::$message = 'file_configure_not_found';
        }
        if (Valid::inGET('server_db_error')) {
            self::$message = 'server_db_error';
        }
        if (Valid::inGET('file_not_found')) {
            self::$message = 'file_not_found';
        }
        if (Valid::inGET('mysql_version_false')) {
            self::$message = 'mysql_version_false';
        }
        if (Valid::inGET('error_message')) {
            self::$error_message = Valid::inGET('error_message');
            if (strrpos(self::$error_message, 'php_network_getaddresses') == TRUE) {
                self::$error_message = lang('database_server_error');
            }
            if (strrpos(self::$error_message, 'Access denied for user') == TRUE) {
                self::$error_message = lang('database_login_error');
            }
            if (strrpos(self::$error_message, 'Unknown database') == TRUE) {
                self::$error_message = lang('database_table_error');
            }
        }
    }

}
