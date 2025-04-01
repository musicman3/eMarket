<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Clock;

use DateTimeImmutable;
use Psr\Clock\ClockInterface;

/**
 * FrozenClock class (compatible with psr-20)
 *
 * @package Core\Clock
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class FrozenClock implements ClockInterface {

    /** @var DateTimeImmutable */
    private $now;

    /**
     * Constructor
     *
     * @param string $now DateTimeImmutable argument ($datetime)
     */
    public function __construct(string $now = 'now') {
        $this->now = new DateTimeImmutable($now);
    }

    /**
     * Now
     * 
     * @return object DateTimeImmutable
     *
     */
    public function now(): DateTimeImmutable {
        return $this->now;
    }

    /**
     * Set date
     * 
     * @param string $date Date
     *
     */
    public function set(string $date) {

        $this->now = new DateTimeImmutable($date);
    }

}
