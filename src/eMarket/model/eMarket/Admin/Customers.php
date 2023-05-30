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
use Cruder\Db;

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

    public static $routing_parameter = 'customers';
    public $title = 'title_customers_index';
    public static int $status = 0;
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
        HeaderMenu::$menu[HeaderMenu::$menu_marketing][] = ['?route=customers', 'bi-people-fill', lang('menu_customers'), '', 'false'];
    }

    /**
     * Status
     *
     */
    private function status(): void {
        if (Valid::inPOST('status')) {

            $status_data = Db::connect()
                    ->read(TABLE_CUSTOMERS)
                    ->selectValue('status')
                    ->where('id=', Valid::inPOST('status'))
                    ->save();

            if ($status_data == 0) {
                self::$status = 1;
            }

            Db::connect()
                    ->update(TABLE_CUSTOMERS)
                    ->set('status', self::$status)
                    ->where('id=', Valid::inPOST('status'))
                    ->save();

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            Db::connect()
                    ->delete(TABLE_CUSTOMERS)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        $search = '%' . Valid::inGET('search') . '%';
        if (Valid::inGET('search')) {

            $lines = Db::connect()
                    ->read(TABLE_CUSTOMERS)
                    ->selectIndex('*')
                    ->where('firstname {{LIKE}}', $search)
                    ->or('lastname {{LIKE}}', $search)
                    ->or('middle_name {{LIKE}}', $search)
                    ->or('email {{LIKE}}', $search)
                    ->orderByDesc('id')
                    ->save();
        } else {

            $lines = Db::connect()
                    ->read(TABLE_CUSTOMERS)
                    ->selectIndex('*')
                    ->orderByDesc('id')
                    ->save();
        }

        Pages::data($lines);
    }

}
