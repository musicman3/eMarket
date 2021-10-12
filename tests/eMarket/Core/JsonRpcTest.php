<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use PHPUnit\Framework\TestCase;

use eMarket\Core\{
    JsonRpc
};

class JsonRpcTest extends TestCase {

    public function testEncodeGetData() {
        $result = JsonRpc::encodeGetData('1', 'get', []);
        $this->assertIsString($result);
    }

}
