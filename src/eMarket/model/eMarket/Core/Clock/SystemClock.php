<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Clock;

use DateTimeImmutable;
use DateTimeZone;
use Psr\Clock\ClockInterface;

/**
 * SystemClock class (compatible with psr-20)
 *
 * @package Core\Clock
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class SystemClock implements ClockInterface {

    /** @var DateTimeZone */
    private $timezone;

    /**
     * Constructor
     *
     * @param string $timezone DateTimeZone argument ($timezone)
     */
    public function __construct(string $timezone = null) {

        if ($timezone) {
            $this->timezone = new DateTimeZone($timezone);
        } else {
            $this->timezone = new DateTimeZone(date_default_timezone_get());
        }
    }

    /**
     * Now
     * 
     * @return object DateTimeImmutable
     *
     */
    public function now(): DateTimeImmutable {
        return new DateTimeImmutable('now', $this->timezone);
    }

    /**
     * Get date
     * 
     * @param string $date Date with DateTimeImmutable format
     * @return object DateTimeImmutable
     *
     */
    public function get(string $date): DateTimeImmutable {

        return new DateTimeImmutable($date, $this->timezone);
    }

}
