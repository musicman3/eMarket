<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use eMarket\Core\{
    Valid,
    Func
};

/**
 * Index
 *
 * @package Admin
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
    public function route() {
        if (Valid::inGET('route') != '') {
            $path = ROOT . '/controller/admin/pages/' . Valid::inGET('route') . '/index.php';
        } else {
            $path = ROOT . '/controller/admin/pages/dashboard/index.php';
        }
        return Func::outputDataFiltering($path);
    }

}
