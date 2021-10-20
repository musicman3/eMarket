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
        $data = urlencode(json_encode([
            'jsonrpc' => '2.0',
            'method' => 'Invoice',
            'param' => [],
            'id' => '1',
        ]));
        $result = JsonRpc::encodeGetData('1', 'Invoice', []);
        $this->assertIsString($result);
        $this->assertSame($result, '/services/jsonrpc/?request=' . $data);
    }

    /**
     * decodeGetData()
     * 
     */
    public function testDecodeGetData() {
        $request = [
            'request' => urlencode(json_encode([
                'jsonrpc' => '2.0',
                'method' => 'Invoice',
                'param' => ['1', '2'],
                'id' => 'JamBfqnLPAUHZMMxGlcSlPLPLBEPJZRq7av2L9kS2oTruYx2WwqJMfVHGcmEq5vj',
        ]))];

        Valid::requestSimulator('get', $request);

        $eMarket = new JsonRpc();
        $this->assertIsArray($eMarket->decodeGetData('param'));
        $this->assertSame($eMarket->decodeGetData('param')[0], '1');
        $this->assertSame($eMarket->decodeGetData('param')[1], '2');
        $this->assertSame($eMarket->decodeGetData('jsonrpc'), '2.0');
        $this->assertSame($eMarket->decodeGetData('method'), 'Invoice');
        $this->assertSame($eMarket->decodeGetData('id'), 'JamBfqnLPAUHZMMxGlcSlPLPLBEPJZRq7av2L9kS2oTruYx2WwqJMfVHGcmEq5vj');
        $this->assertIsArray($eMarket->decodeGetData(null));
        $this->assertCount(4, $eMarket->decodeGetData(null));

        Valid::closeRequestSimulator();
    }

}
