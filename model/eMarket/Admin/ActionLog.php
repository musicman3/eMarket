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
 * Actions Log
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class ActionLog {

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
        HeaderMenu::$menu[HeaderMenu::$menu_tools][] = ['?route=action_log', 'bi-exclamation-circle', lang('menu_action_log'), '', 'false'];
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete') == 'delete' && file_exists(ROOT . '/storage/logs/actions.log')) {
            
            unlink(ROOT . '/storage/logs/actions.log');
            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        if (file_exists(ROOT . '/storage/logs/actions.log')) {
            $lines = array_reverse(file(ROOT . '/storage/logs/actions.log'));
        } else {
            $lines = [];
        }

        Pages::data($lines);
    }

    /**
     * Error class
     *
     * @param string $input input data
     * @return string bootstrap class
     */
    public static function errorClass(string $input): string {

        if (strrpos($input, 'eMarket.INFO:') == TRUE) {
            return 'table-success';
        }
        if (strrpos($input, 'eMarket.WARNING:') == TRUE) {
            return 'table-warning';
        }
        if (strrpos($input, 'eMarket.ERROR:') == TRUE) {
            return 'table-danger';
        }
    }

}
