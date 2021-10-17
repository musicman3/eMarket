<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use PHPUnit\Framework\TestCase;
use eMarket\Core\{
    Valid
};

final class ValidTest extends TestCase {

    /**
     * Request simulator helper for test
     *
     * @param mixed $data Input data
     */
    public function requestSimulatorHelper(mixed $data): void {
        Valid::requestSimulator('json', $data);
        Valid::requestSimulator('post', $data);
        Valid::requestSimulator('get', $data);
        Valid::requestSimulator('server', $data);
        Valid::requestSimulator('cookie', $data);

        $this->assertSame($data, Valid::$post_json_simulator);
        $this->assertSame($data, Valid::$post_simulator);
        $this->assertSame($data, Valid::$get_simulator);
        $this->assertSame($data, Valid::$server_simulator);
        $this->assertSame($data, Valid::$cookie_simulator);

        Valid::closeRequestSimulator();
    }

    /**
     * requestSimulator()
     * 
     */
    public function testRequestSimulator() {
        $this->requestSimulatorHelper('string');
        $this->requestSimulatorHelper(1);
        $this->requestSimulatorHelper([]);
        $this->requestSimulatorHelper(true);
    }

    /**
     * closeRequestSimulator()
     * 
     */
    public function testCloseRequestSimulator() {

        Valid::closeRequestSimulator();

        $this->assertFalse(Valid::$post_json_simulator);
        $this->assertFalse(Valid::$post_simulator);
        $this->assertFalse(Valid::$get_simulator);
        $this->assertFalse(Valid::$server_simulator);
        $this->assertFalse(Valid::$cookie_simulator);
    }

}
