<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use Cruder\Db;

/**
 * Extra Modules
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class ExtraModules {

    /**
     * List of Tabs modules
     * @return array
     */
    public static function extraModulesAvailable(): array {

        $data = Db::connect()
                ->read(TABLE_MODULES)
                ->selectAssoc('*')
                ->where('active=', 1)
                ->and('type=', 'extra')
                ->save();

        $output = [];
        foreach ($data as $module) {
            array_push($output, $module['name']);
        }
        return $output;
    }

    /**
     * Loading data from tabs modules
     * 
     * @return array
     */
    public static function loadData(): array {

        $modules_names = self::extraModulesAvailable();

        $modules_data = [];
        foreach ($modules_names as $name) {
            $namespace = '\eMarket\Core\Modules\Extra\\' . ucfirst($name);
            $load = $namespace::load();
            array_push($modules_data, $load);
        }
        return $modules_data;
    }

}
