<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Catalog;

use eMarket\Core\{
    Valid,
    Func
};

/**
 * Index
 *
 * @package Catalog
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Index {

    /**
     * Route
     *
     * @return string url
     */
    public function route(): string {
        if (Valid::inGET('route') != '') {
            $path = ROOT . '/controller/catalog/pages/' . Valid::inGET('route') . '/index.php';
        } else {
            $path = ROOT . '/controller/catalog/pages/catalog/index.php';
        }
        return Func::outputDataFiltering($path);
    }

}
