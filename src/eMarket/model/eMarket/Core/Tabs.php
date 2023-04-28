<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use Cruder\Cruder;

/**
 * Tabs
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class Tabs {

    /**
     * List of Tabs modules
     * @return array
     */
    public static function tabsModulesAvailable(): array {

        $db = new Cruder();

        $data = $db->read(TABLE_MODULES)
                ->selectAssoc('*')
                ->where('active=', 1)
                ->and('type=', 'tabs')
                ->save();

        $output = [];
        foreach ($data as $tabs_module) {
            array_push($output, $tabs_module['name']);
        }
        return $output;
    }

    /**
     * Loading data from tabs modules
     * 
     * @return array
     */
    public static function loadData(): array {

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
