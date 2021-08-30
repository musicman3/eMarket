<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\JsonRpc;

use eMarket\Core\{
    Valid
};

/**
 * jsonRPC testing
 *
 * @package jsonRPC
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Testing {

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->testing();
    }

    /**
     * Testing
     *
     * Note: successful jsonRPC request

      'jsonrpc' => '2.0',
      'method' => 'Testing',
      'param' => ['param_1' => 'test'],
      'id' => '1',
     * 
     */
    public function testing() {
        if (Valid::inPostJson('param')['param_1'] == 'test') {
            echo json_encode([
                'jsonrpc' => '2.0',
                'result' => 'Successful request',
                'id' => Valid::inPostJson('id')
            ]);
        } else {
            echo json_encode([
                'jsonrpc' => '2.0',
                'error' => 'Invalid request',
                'id' => Valid::inPostJson('id')
            ]);
        }
    }

}
