<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use PHPUnit\Framework\TestCase;
use eMarket\Core\{
    JsonRpc,
    Valid
};

class JsonRpcTest extends TestCase {

    public function testEncodeGetData() {
        $result = JsonRpc::encodeGetData('1', 'get', []);
        $this->assertIsString($result);
    }

    public function testDecodeGetData() {
        
        Valid::$get_simulator = [
            'request' => urlencode(json_encode([
                'jsonrpc' => '2.0',
                'method' => 'POST',
                'param' => [],
                'id' => '1',
        ]))];
        
        $eMarket = new JsonRpc();
        $this->assertIsString($eMarket->decodeGetData('jsonrpc'));
        $this->assertIsString($eMarket->decodeGetData('method'));
        $this->assertIsArray($eMarket->decodeGetData('param'));
        $this->assertIsString($eMarket->decodeGetData('id'));
        $this->assertIsArray($eMarket->decodeGetData(null));
    }

}
