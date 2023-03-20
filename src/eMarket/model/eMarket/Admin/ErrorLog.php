<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Pages,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Error Log
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class ErrorLog {

    public static $routing_parameter = 'error_log';
    public $title = 'title_error_log_index';

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->delete();
        $this->data();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_tools][] = ['?route=error_log', 'bi-exclamation-circle', lang('menu_error_log'), '', 'false'];
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete') == 'delete' && file_exists(ROOT . '/storage/logs/errors.log')) {
            unlink(ROOT . '/storage/logs/errors.log');

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        $lines = [];
        if (file_exists(ROOT . '/storage/logs/errors.log')) {
            $lines = array_reverse(file(ROOT . '/storage/logs/errors.log'));
        }

        Pages::data($lines);
    }

    /**
     * Error class
     *
     * @param string $input input data
     * @return string bootstrap class
     */
    public static function errorClass(?string $input): string {
        $output = '';

        if (strrpos($input, 'eMarket.NOTICE:') == TRUE) {
            $output = 'table-secondary';
        }
        if (strrpos($input, 'eMarket.WARNING:') == TRUE) {
            $output = 'table-primary';
        }
        if (strrpos($input, 'eMarket.ERROR:') == TRUE) {
            $output = 'table-warning';
        }
        if (strrpos($input, 'eMarket.CRITICAL:') == TRUE) {
            $output = 'table-danger';
        }
        if (strrpos($input, 'eMarket.ALERT:') == TRUE) {
            $output = 'table-dark';
        }

        return $output;
    }

}
