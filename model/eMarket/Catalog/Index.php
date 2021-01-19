<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Catalog;

use \eMarket\Core\{
    Valid
};

/**
 * Index
 *
 * @package Catalog
 * @author eMarket
 * 
 */
class Index {

    /**
     * Route
     *
     * @return string url
     */
    public function route() {
        if (Valid::inGET('route') != '') {
            return ROOT . '/controller/catalog/pages/' . Valid::inGET('route') . '/index.php';
        } else {
            return ROOT . '/controller/catalog/pages/catalog/index.php';
        }
    }

}
