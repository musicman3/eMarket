<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Valid
};

/**
 * jsonRPC
 *
 * @package Core
 * @author eMarket
 * 
 */
class JsonRpc {

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->loadData();
    }

    /**
     * Loading data from Services
     * 
     * @return array
     */
    public function loadData() {
        if (Valid::inPostJson('jsonrpc') == '2.0' && Valid::inPostJson('method')) {
            $namespace = '\eMarket\JsonRpc\\' . Valid::inPostJson('method');
            new $namespace;
        }
    }

}
