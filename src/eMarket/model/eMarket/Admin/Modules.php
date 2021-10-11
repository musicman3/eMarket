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
    Pdo,
    Valid
};
use eMarket\Admin\Modules;

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
     * Add
     *
     */
    public function add(): void {
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
    public function edit(): void {
        if (Valid::inPOST('edit_active')) {

            if (Valid::inPOST('switch_active') == 'on') {
                $active = 1;
            }
            if (!Valid::inPOST('switch_active')) {
                $active = 0;
            }
            $module = explode('_', Valid::inPOST('edit_active'));
            Pdo::action("UPDATE " . TABLE_MODULES . " SET active=? WHERE name=? AND type=?", [$active, $module[1], $module[0]]);

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
    public function delete(): void {
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
    public function data(): void {
        self::$installed = Pdo::getAssoc("SELECT name, type FROM " . TABLE_MODULES . "", []);
        self::$installed_active = Pdo::getAssoc("SELECT name, type FROM " . TABLE_MODULES . " WHERE active=?", [1]);
    }

    /**
     * Bootstrap class helper
     *
     * @param string $type type
     * @return string Bootstrap class
     */
    public function class(?string $type): string {
        if (Valid::inGET('active') == $type OR (!Valid::inGET('active') && $type == array_key_first($_SESSION['MODULES_INFO']))) {
            $class = 'active';
        } else {
            $class = '';
        }
        return $class;
    }

    /**
     * Filter helper & Bootstrap class helper
     *
     * @param string $type type
     */
    public function filter(?string $type): void {
        if (Valid::inGET('active') == $type OR (!Valid::inGET('active') && $type == array_key_first($_SESSION['MODULES_INFO']))) {
            self::$class_tab = 'tab-pane fade show in active';
        } else {
            self::$class_tab = 'tab-pane fade';
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
        if (in_array($key, Modules::$installed_filter_active)) {
            $active = 'table-success';
        } else {
            $active = 'table-danger';
        }
        return $active;
    }

}
