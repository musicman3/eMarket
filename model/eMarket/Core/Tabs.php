<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
};

/**
 * Tabs
 *
 * @package Tabs
 * @author eMarket
 * 
 */
final class Tabs {

    /**
     * List of Tabs modules
     * @param string $name Tabs module name
     * @return array
     */
    public static function tabsModulesAvailable() {
        $data = Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE active=? AND type=?", [1, 'tabs']);
        $output = [];
        foreach ($data as $tabs_module) {
            array_push($output, $tabs_module['name']);
        }
        return $output;
    }

    /**
     * Loading data from tabs modules
     * 
     * @param array $input Available modules
     * @return array
     */
    public static function loadData() {

        $modules_names = self::tabsModulesAvailable();

        $modules_data = [];
        foreach ($modules_names as $name) {
            $namespace = '\eMarket\Core\Modules\Tabs\\' . ucfirst($name);
            $load = $namespace::load();
            array_push($modules_data, $load);
        }
        return $modules_data;
    }

}
