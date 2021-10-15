<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use PHPUnit\Framework\TestCase;
use eMarket\Core\{
    Func
};

final class FuncTest extends TestCase {

    // Sample 1
    private array $sample_1 = [
        ['id' => '1', 'country' => 'Germany', 'city' => 'Berlin'],
        ['id' => '2', 'country' => 'Russia', 'city' => 'Moskow'],
        ['id' => '3', 'country' => 'USA', 'city' => 'New York'],
        ['id' => '4', 'country' => 'USA', 'city' => 'Boston'],
        ['id' => '5', 'country' => 'Russia', 'city' => 'Saint-Petersburg'],
        ['id' => '6', 'country' => 'USA', 'city' => 'Chicago']
    ];
    // Sample 2
    private array $sample_2 = ['12-0', '12-1'];
    // Sample 3
    private array $sample_3 = ['apple', 'banana', 'green', 'mango'];
    // Sample 4
    private array $sample_4 = [
        ['id' => '1', 'price' => '1250'],
        ['id' => '2', 'price' => '1320']
    ];
    // Sample 5
    private array $sample_5 = ['banana', '', 'apple'];

    /**
     * filterArrayToKey()
     * 
     */
    public function testFilterArrayToKey() {

        $result = Func::filterArrayToKey($this->sample_1, 'country', 'USA', 'city', true);
        $this->assertSame($result[0], 'New York');
        $this->assertSame($result[1], 'Boston');
        $this->assertSame($result[2], 'Chicago');
        $this->assertIsArray($result);
        $this->assertCount(3, $result);

        $result2 = Func::filterArrayToKey($this->sample_1, 'country', 'USA', 'city');
        $this->assertSame($result2[0], 'Boston');
        $this->assertSame($result2[1], 'Chicago');
        $this->assertSame($result2[2], 'New York');
        $this->assertIsArray($result2);
        $this->assertCount(3, $result2);

        $result3 = Func::filterArrayToKey($this->sample_1, 'city', 'Boston', 'country');
        $this->assertSame($result3[0], 'USA');
        $this->assertIsArray($result3);
        $this->assertCount(1, $result3);
    }

    /**
     * filterArrayToKeyAssoc()
     * 
     */
    public function testFilterArrayToKeyAssoc() {

        $result = Func::filterArrayToKeyAssoc($this->sample_1, 'country', 'USA', 'city', 'id');
        $this->assertSame($result[4], 'Boston');
        $this->assertSame($result[6], 'Chicago');
        $this->assertSame($result[3], 'New York');
        $this->assertIsArray($result);
        $this->assertCount(3, $result);
    }

    /**
     * arrayExplode()
     * 
     */
    public function testArrayExplode() {

        $result = Func::arrayExplode($this->sample_2, '-');
        $this->assertSame($result[0][0], '12');
        $this->assertSame($result[0][1], '0');
        $this->assertSame($result[1][0], '12');
        $this->assertSame($result[1][1], '1');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    /**
     * deleteValInArray()
     * 
     */
    public function testDeleteValInArray() {

        $result = Func::deleteValInArray($this->sample_3, ['banana', 'mango']);
        $this->assertSame($result[0], 'apple');
        $this->assertSame($result[1], 'green');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    /**
     * resetKeyAssocArray()
     * 
     */
    public function testResetKeyAssocArray() {

        $result = Func::resetKeyAssocArray($this->sample_4);
        $this->assertSame($result[0][0], '1');
        $this->assertSame($result[0][1], '1250');
        $this->assertSame($result[1][0], '2');
        $this->assertSame($result[1][1], '1320');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    /**
     * deleteEmptyInArray()
     * 
     */
    public function testDeleteEmptyInArray() {
        $result = Func::deleteEmptyInArray($this->sample_5);
        $this->assertSame($result[0], 'banana');
        $this->assertSame($result[1], 'apple');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

}
