<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Clock;

use PHPUnit\Framework\TestCase;
use eMarket\Core\{
    Clock\SystemClock
};

final class SystemClockTest extends TestCase {

    /**
     * nowSqlDateTime()
     * 
     */
    public function testNowSqlDateTime() {
        $result = SystemClock::nowSqlDateTime();
        $this->assertIsString($result);
        $this->assertSame(count_chars($result, 0)[45], 2);
        $this->assertSame(count_chars($result, 0)[58], 2);
        $this->assertSame(count_chars($result, 0)[32], 1);
    }

    /**
     * nowSqlDate()
     * 
     */
    public function testNowSqlDate() {
        $result = SystemClock::nowSqlDate();
        $this->assertIsString($result);
        $this->assertSame(count_chars($result, 0)[45], 2);
    }

    /**
     * nowUnixTime()
     * 
     */
    public function testNowUnixTime() {
        $result = SystemClock::nowUnixTime();
        $this->assertIsString($result);
        $this->assertIsInt((int) $result);
    }

    /**
     * nowFormatDate()
     * 
     */
    public function testNowFormatDate() {
        $result = SystemClock::nowFormatDate('d.m.Y H:i:s');
        $this->assertIsString($result);
        $this->assertSame(count_chars($result, 0)[46], 2);
        $this->assertSame(count_chars($result, 0)[58], 2);
        $this->assertSame(count_chars($result, 0)[32], 1);
    }

    /**
     * getSqlDateTime()
     * 
     */
    public function testGetSqlDateTime() {
        $result = SystemClock::getSqlDateTime('2022-02-12 12:12:12 +03');
        $this->assertIsString($result);
        $this->assertSame($result, '2022-02-12 12:12:12');
    }

    /**
     * getSqlDate()
     * 
     */
    public function testGetSqlDate() {
        $result = SystemClock::getSqlDate('2022-02-12 12:12:12 +03');
        $this->assertIsString($result);
        $this->assertSame($result, '2022-02-12');
    }

    /**
     * getUnixTime()
     * 
     */
    public function testGetUnixTime() {
        $result = SystemClock::getUnixTime('2022-02-12 12:12:12 +03');
        $this->assertIsString($result);
        $this->assertSame($result, '1644657132');
    }

}
