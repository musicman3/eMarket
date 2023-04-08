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
    private array $sample = [
        ['id' => '1', 'country' => 'Germany', 'city' => 'Berlin'],
        ['id' => '2', 'country' => 'Russia', 'city' => 'Moskow'],
        ['id' => '3', 'country' => 'USA', 'city' => 'New York'],
        ['id' => '4', 'country' => 'USA', 'city' => 'Boston'],
        ['id' => '5', 'country' => 'Russia', 'city' => 'Saint-Petersburg'],
        ['id' => '6', 'country' => 'USA', 'city' => 'Chicago']
    ];

    /**
     * filterArrayToKey()
     * 
     */
    public function testFilterArrayToKey() {
        $result = Func::filterArrayToKey($this->sample, 'country', 'USA', 'city', true);
        $this->assertSame($result[0], 'New York');
        $this->assertSame($result[1], 'Boston');
        $this->assertSame($result[2], 'Chicago');
        $this->assertIsArray($result);
        $this->assertCount(3, $result);

        $result2 = Func::filterArrayToKey($this->sample, 'country', 'USA', 'city');
        $this->assertSame($result2[0], 'Boston');
        $this->assertSame($result2[1], 'Chicago');
        $this->assertSame($result2[2], 'New York');
        $this->assertIsArray($result2);
        $this->assertCount(3, $result2);

        $result3 = Func::filterArrayToKey($this->sample, 'city', 'Boston', 'country');
        $this->assertSame($result3[0], 'USA');
        $this->assertIsArray($result3);
        $this->assertCount(1, $result3);
    }

    /**
     * filterArrayToKeyAssoc()
     * 
     */
    public function testFilterArrayToKeyAssoc() {
        $result = Func::filterArrayToKeyAssoc($this->sample, 'country', 'USA', 'city', 'id');
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
        $sample = ['12-0', '12-1'];
        $result = Func::arrayExplode($sample, '-');
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
        $sample = ['apple', 'banana', 'green', 'mango'];
        $result = Func::deleteValInArray($sample, ['banana', 'mango']);
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
        $sample = [
            ['id' => '1', 'price' => '1250'],
            ['id' => '2', 'price' => '1320']
        ];
        $result = Func::resetKeyAssocArray($sample);
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
        $sample = ['banana', '', 'apple'];
        $result = Func::deleteEmptyInArray($sample);
        $this->assertSame($result[0], 'banana');
        $this->assertSame($result[1], 'apple');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
    }

    /**
     * deleteGet()
     * 
     */
    public function testDeleteGet() {
        $result = Func::deleteGet('value_1=banana&value_2=apple&value_3=orange', 'value_2');
        $this->assertIsString($result);
        $this->assertSame('value_1=banana&value_3=orange', $result);
    }

    /**
     * outputDataFiltering()
     * 
     */
    public function testOutputDataFiltering() {
        $sample = [["script /script javascript: /. ./ /'", ["script /script javascript: /. ./ /'"]]];
        $result = Func::outputDataFiltering($sample);
        $this->assertIsArray($result);
        $this->assertSame($result[0][0], '!s-c-r-i-p-t! /!s-c-r-i-p-t! java!s-c-r-i-p-t!: !/.! !./! /&#8216;');
        $this->assertSame($result[0][1][0], '!s-c-r-i-p-t! /!s-c-r-i-p-t! java!s-c-r-i-p-t!: !/.! !./! /&#8216;');
    }

    /**
     * recursiveArrayReplace()
     * 
     */
    public function testRecursiveArrayReplace() {
        $find = ['banana', 'apple'];
        $replace = ['/banana', '/apple'];
        $sample = [['banana apple', ['banana apple']]];

        $result = Func::recursiveArrayReplace($find, $replace, $sample);
        $this->assertIsArray($result);
        $this->assertSame($result[0][0], '/banana /apple');
        $this->assertSame($result[0][1][0], '/banana /apple');

        $result_2 = Func::recursiveArrayReplace($find[0], $replace[0], $sample);
        $this->assertIsArray($result_2);
        $this->assertSame($result_2[0][0], '/banana apple');
        $this->assertSame($result_2[0][1][0], '/banana apple');
    }

    /**
     * filterData()
     * 
     */
    public function testFilterData() {
        $sample = [
            ['language' => 'english', 'type' => '1'],
            ['language' => 'russian', 'type' => '2']
        ];
        $result = Func::filterData($sample, 'language', 'english');
        $this->assertSame($result[0]['type'], '1');
        $this->assertIsArray($result);
        $this->assertCount(1, $result);
    }

    /**
     * arrayMergeOriginKey()
     * 
     */
    public function testArrayMergeOriginKey() {
        $sample = ['3', '2', '1'];
        $sample_2 = ['4', '6', '7'];
        $result = Func::arrayMergeOriginKey('cat', 'prod', $sample, $sample_2);
        $this->assertSame($result['cat']['0'], '3');
        $this->assertSame($result['cat']['1'], '2');
        $this->assertSame($result['cat']['2'], '1');
        $this->assertSame($result['prod']['3a'], '4');
        $this->assertSame($result['prod']['4a'], '6');
        $this->assertSame($result['prod']['5a'], '7');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertCount(3, $result['cat']);
        $this->assertCount(3, $result['prod']);
    }

    /**
     * deleteValueFromArray()
     * 
     */
    public function testRemoveValueFromArrayLevel() {
        $sample = [
            'apple' => [
                '0' => '17',
                '1' => '2',
                '2' => '6'],
            'banana' => [
                '0' => '4',
                '1' => '6',
                '2' => '7']
        ];
        $result = Func::removeValueFromArrayLevel('apple', '2', $sample);
        $this->assertSame($result['apple'][0], '17');
        $this->assertSame($result['apple'][1], '6');
        $this->assertSame($result['banana'][0], '4');
        $this->assertSame($result['banana'][1], '6');
        $this->assertSame($result['banana'][2], '7');
        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertCount(2, $result['apple']);
        $this->assertCount(3, $result['banana']);
    }

}
