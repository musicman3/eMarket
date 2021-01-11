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

    public static $sql_data = FALSE;
    public static $json_data = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->delete();
        $this->data();
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Valid::inPOST('delete') == 'delete' && file_exists(ROOT . '/model/work/errors.log')) {
            unlink(ROOT . '/model/work/errors.log');

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
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

        \eMarket\Pages::table($lines);
    }

}
