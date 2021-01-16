<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Customers
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Customers {

    public static $status = FALSE;
    public static $json_data = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->status();
        $this->delete();
        $this->data();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu() {
        \eMarket\Admin\HeaderMenu::$menu[\eMarket\Admin\HeaderMenu::$menu_customers][] = ['?route=customers', 'glyphicon glyphicon glyphicon-user', lang('menu_customers'), '', 'false'];
    }

    /**
     * Status
     *
     */
    public function status() {
        if (\eMarket\Core\Valid::inPOST('status')) {

            $status_data = \eMarket\Core\Pdo::getCell("SELECT status FROM " . TABLE_CUSTOMERS . " WHERE id=?", [\eMarket\Core\Valid::inPOST('status')]);

            if ($status_data == 0) {
                self::$status = 1;
            } else {
                self::$status = 0;
            }

            \eMarket\Core\Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [self::$status, \eMarket\Core\Valid::inPOST('status')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Core\Valid::inPOST('delete')) {

            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_CUSTOMERS . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        $search = '%' . \eMarket\Core\Valid::inGET('search') . '%';
        if (\eMarket\Core\Valid::inGET('search')) {
            $lines = \eMarket\Core\Pdo::getColRow("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE firstname LIKE? OR lastname LIKE? OR middle_name LIKE? OR email LIKE? ORDER BY id DESC", [$search, $search, $search, $search]);
        } else {
            $lines = \eMarket\Core\Pdo::getColRow("SELECT * FROM " . TABLE_CUSTOMERS . " ORDER BY id DESC", []);
        }

        \eMarket\Core\Pages::table($lines);
    }

}
