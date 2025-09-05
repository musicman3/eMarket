<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\JsonRpc;

use eMarket\Core\{
    JsonRpc
};

/**
 * Update class
 *
 * @package JsonRpc
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Rpc {

    public static $routing_parameter = 'Rpc';

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->routing();
    }

    /**
     * Init
     * 
     */
    public function routing(): void {
        
        $jsonRpc = new JsonRpc();
        $methods_available = $jsonRpc->routing();

        foreach ($methods_available as $method) {
            new $method['method']();
        }

        $jsonRpc->response();
    }
}
