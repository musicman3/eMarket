<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Error Log
 *
 * @package Admin
 * @author eMarket
 * 
 */
class ErrorLog {

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
    public static function menu() {
        \eMarket\Admin\HeaderMenu::$menu[\eMarket\Admin\HeaderMenu::$menu_tools][] = ['?route=error_log', 'glyphicon glyphicon-exclamation-sign', lang('menu_error_log'), '', 'false'];
    }    

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Core\Valid::inPOST('delete') == 'delete' && file_exists(ROOT . '/model/work/errors.log')) {
            unlink(ROOT . '/model/work/errors.log');

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        if (file_exists(ROOT . '/model/work/errors.log')) {
            $lines = array_reverse(file(ROOT . '/model/work/errors.log'));
        } else {
            $lines = [];
        }

        \eMarket\Core\Pages::table($lines);
    }

}
