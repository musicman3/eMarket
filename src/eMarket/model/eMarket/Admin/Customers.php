<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Messages,
    Pdo,
    Pages,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Customers
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
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
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_customers][] = ['?route=customers', 'bi-people-fill', lang('menu_customers'), '', 'false'];
    }

    /**
     * Status
     *
     */
    public function status(): void {
        if (Valid::inPOST('status')) {

            $status_data = Pdo::getValue("SELECT status FROM " . TABLE_CUSTOMERS . " WHERE id=?", [Valid::inPOST('status')]);

            if ($status_data == 0) {
                self::$status = 1;
            } else {
                self::$status = 0;
            }

            Pdo::action("UPDATE " . TABLE_CUSTOMERS . " SET status=? WHERE id=?", [self::$status, Valid::inPOST('status')]);

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {

            Pdo::action("DELETE FROM " . TABLE_CUSTOMERS . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $search = '%' . Valid::inGET('search') . '%';
        if (Valid::inGET('search')) {
            $lines = Pdo::getIndex("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE firstname LIKE? OR lastname LIKE? OR middle_name LIKE? OR email LIKE? ORDER BY id DESC", [$search, $search, $search, $search]);
        } else {
            $lines = Pdo::getIndex("SELECT * FROM " . TABLE_CUSTOMERS . " ORDER BY id DESC", []);
        }

        Pages::data($lines);
    }

}
