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

final class JsonRpcTest extends TestCase {

    /**
     * encodeGetData()
     * 
     */
    public function testEncodeGetData() {

        $result = JsonRpc::encodeGetData('1', 'get', []);
        $this->assertIsString($result);
    }

    /**
     * decodeGetData()
     * 
     */
    public function testDecodeGetData() {

        $request = [
            'request' => urlencode(json_encode([
                'jsonrpc' => '2.0',
                'method' => 'GET',
                'param' => [],
                'id' => '1',
        ]))];

        Valid::requestSimulator('get', $request);

        $eMarket = new JsonRpc();
        $this->assertIsString($eMarket->decodeGetData('jsonrpc'));
        $this->assertEquals($eMarket->decodeGetData('jsonrpc'), '2.0');
        $this->assertIsString($eMarket->decodeGetData('method'));
        $this->assertIsArray($eMarket->decodeGetData('param'));
        $this->assertIsString($eMarket->decodeGetData('id'));
        $this->assertIsArray($eMarket->decodeGetData(null));
        $this->assertCount(4, $eMarket->decodeGetData(null));

        Valid::closeRequestSimulator();
    }

}
