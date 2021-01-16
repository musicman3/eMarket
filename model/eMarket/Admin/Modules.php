<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Modules
 *
 * @package Admin
 * @author eMarket
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
    public function add() {
        if (\eMarket\Core\Valid::inPOST('add')) {
            $module = explode('_', \eMarket\Core\Valid::inPOST('add'));
            $namespace = '\eMarket\Core\Modules\\' . ucfirst($module[0]) . '\\' . ucfirst($module[1]);
            $namespace::install($module);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (\eMarket\Core\Valid::inPOST('edit_active')) {

            if (\eMarket\Core\Valid::inPOST('switch_active') == 'on') {
                $active = 1;
            }
            if (!\eMarket\Core\Valid::inPOST('switch_active')) {
                $active = 0;
            }
            $module = explode('_', \eMarket\Core\Valid::inPOST('edit_active'));
            \eMarket\Core\Pdo::action("UPDATE " . TABLE_MODULES . " SET active=? WHERE name=? AND type=?", [$active, $module[1], $module[0]]);
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Core\Valid::inPOST('delete')) {
            $module = explode('_', \eMarket\Core\Valid::inPOST('delete'));
            $namespace = '\eMarket\Core\Modules\\' . ucfirst($module[0]) . '\\' . ucfirst($module[1]);
            $namespace::uninstall($module);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$installed = \eMarket\Core\Pdo::getColAssoc("SELECT name, type FROM " . TABLE_MODULES . "", []);
        self::$installed_active = \eMarket\Core\Pdo::getColAssoc("SELECT name, type FROM " . TABLE_MODULES . " WHERE active=?", [1]);
    }

    /**
     * Bootstrap class helper
     *
     * @param string $type type
     * @return string Bootstrap class
     */
    public function class($type) {
        if (\eMarket\Core\Valid::inGET('active') == $type OR (!\eMarket\Core\Valid::inGET('active') && $type == array_key_first($_SESSION['MODULES_INFO']))) {
            $class = '<li class="active">';
        } else {
            $class = '<li>';
        }
        return $class;
    }

    /**
     * Filter helper & Bootstrap class helper
     *
     * @param string $type type
     */
    public function filter($type) {
        if (\eMarket\Core\Valid::inGET('active') == $type OR (!\eMarket\Core\Valid::inGET('active') && $type == array_key_first($_SESSION['MODULES_INFO']))) {
            self::$class_tab = 'tab-pane fade in active';
        } else {
            self::$class_tab = 'tab-pane fade';
        }
        self::$installed_filter = \eMarket\Core\Func::filterArrayToKey(self::$installed, 'type', $type, 'name');
        self::$installed_filter_active = \eMarket\Core\Func::filterArrayToKey(self::$installed_active, 'type', $type, 'name');
    }

    /**
     * Bootstrap class helper
     *
     * @param string $key key
     * @return string Bootstrap class
     */
    public function active($key) {
        if (in_array($key, \eMarket\Admin\Modules::$installed_filter_active)) {
            $active = '<tr class="success">';
        } else {
            $active = '<tr class="danger">';
        }
        return $active;
    }

}
