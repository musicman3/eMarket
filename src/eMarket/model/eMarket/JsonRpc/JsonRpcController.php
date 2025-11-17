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
 * JsonRpcController
 *
 * @package JsonRpc
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class JsonRpcController extends JsonRpc {

    public static $routing_parameter = 'JsonRpcController';

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->controller();
    }

    /**
     * JsonRpc Controller
     *
     */
    public function controller(): void {

        $jsonRpc = new JsonRpc();
        $methods_available = $jsonRpc->routing();

        foreach ($methods_available as $method) {
            $method['method']::$jsonrpc = $this->jsonRpcData($method['method']);
            new $method['method']();
        }

        $jsonRpc->response();
    }
}
