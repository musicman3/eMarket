<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Messages,
    Valid
};
use eMarket\Admin\Modules;
use Cruder\Db;

/**
 * Modules
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Modules {

    public static $routing_parameter = 'modules';
    public $title = 'title_modules_index';
    public static $installed = FALSE;
    public static $installed_active = FALSE;
    public static $installed_filter = FALSE;
    public static $installed_filter_active = FALSE;
    public static $class_tab = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->add();
        $this->edit();
        $this->delete();
        $this->data();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=modules', 'bi-cpu-fill', lang('title_modules_index'), '', 'false'];
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {
            $module = explode('_', Valid::inPOST('add'));
            $namespace = '\eMarket\Core\Modules\\' . ucfirst($module[0]) . '\\' . ucfirst($module[1]);
            $namespace::install($module);

            Messages::alert('add_' . Valid::inPOST('add'), 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    private function edit(): void {
        if (Valid::inPOST('edit_active')) {

            $active = 0;
            if (Valid::inPOST('switch_active') == 'on') {
                $active = 1;
            }

            $module = explode('_', Valid::inPOST('edit_active'));

            Db::connect()
                    ->update(TABLE_MODULES)
                    ->set('active', $active)
                    ->where('name=', $module[1])
                    ->and('type=', $module[0])
                    ->save();

            if (Valid::inPOST('alert_flag') == 'on') {
                Messages::alert('edit_' . Valid::inPOST('edit_active'), 'success', lang('action_completed_successfully'));
            } else {
                Messages::alert('edit_status_' . Valid::inPOST('edit_active'), 'success', lang('action_completed_successfully'), 0, true);
            }
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {
            $module = explode('_', Valid::inPOST('delete'));
            $namespace = '\eMarket\Core\Modules\\' . ucfirst($module[0]) . '\\' . ucfirst($module[1]);
            $namespace::uninstall($module);

            Messages::alert('delete_' . Valid::inPOST('delete'), 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$installed = Db::connect()
                ->read(TABLE_MODULES)
                ->selectAssoc('name, type')
                ->save();

        self::$installed_active = Db::connect()
                ->read(TABLE_MODULES)
                ->selectAssoc('name, type')
                ->where('active=', 1)
                ->save();
    }

    /**
     * Bootstrap class helper
     *
     * @param string $type type
     * @return string Bootstrap class
     */
    public function class(?string $type): string {
        $class = '';
        if (Valid::inGET('active') == $type OR (!Valid::inGET('active') && $type == array_key_first($_SESSION['MODULES_INFO']))) {
            $class = 'active';
        }
        return $class;
    }

    /**
     * Filter helper & Bootstrap class helper
     *
     * @param string $type type
     */
    public function filter(?string $type): void {
        self::$class_tab = 'tab-pane fade';
        if (Valid::inGET('active') == $type OR (!Valid::inGET('active') && $type == array_key_first($_SESSION['MODULES_INFO']))) {
            self::$class_tab = 'tab-pane fade show in active';
        }
        self::$installed_filter = Func::filterArrayToKey(self::$installed, 'type', $type, 'name');
        self::$installed_filter_active = Func::filterArrayToKey(self::$installed_active, 'type', $type, 'name');
    }

    /**
     * Bootstrap class helper
     *
     * @param string $key key
     * @return string Bootstrap class
     */
    public function active(int|string $key): string {
        $active = 'table-danger';
        if (in_array($key, Modules::$installed_filter_active)) {
            $active = 'table-success';
        }
        return $active;
    }

}
