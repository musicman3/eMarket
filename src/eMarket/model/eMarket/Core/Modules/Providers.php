<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules;

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
final class Providers {

    /**
     * List of Providers modules
     * @return array
     */
    private function providersModulesAvailable(): array {

        $data = Db::connect()
                ->read(TABLE_MODULES)
                ->selectAssoc('*')
                ->where('active=', 1)
                ->and('type=', 'providers')
                ->save();

        $output = [];
        foreach ($data as $module) {
            array_push($output, $module['name']);
        }
        return $output;
    }

    /**
     * Loading data from Providers modules
     *
     * @return array
     */
    public function loadData(): array {

        $modules_names = $this->providersModulesAvailable();

        $modules_data = [];
        foreach ($modules_names as $name) {
            $namespace = '\eMarket\Modules\Providers\\' . ucfirst($name);
            $load = $namespace::load();
            array_push($modules_data, $load);
        }
        return $modules_data;
    }
}
