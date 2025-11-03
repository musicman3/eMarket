<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use Cruder\{
    Pdo as CruderPdo
};

/**
 * Debug class
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 *
 */
class Debug {

    public static $debug_stopwatch;
    // Use: \eMarket\Core\Debug::$debug_helper = data for debug;
    public static $debug_helper = false;

    /**
     * Array displaying when debugging
     *
     * @param array Input array
     */
    public static function trace(mixed $var): void {
        static $int = 0;
        echo '<pre><b>' . $int . '</b> ';
        print_r($var);
        echo '</pre>';
        $int++;
    }

    /**
     * Displaying debug information
     *
     * @param string Start time
     */
    public static function info(): void {

        $val = Settings::basicSettings('debug');

        if ($val == 1) {
            $tend = microtime(true);

            $totaltime = round(($tend - self::$debug_stopwatch), 2);

            echo lang('debug_page_generation_time') . " " . $totaltime . " " . lang('debug_sec') . "<br>";
            echo lang('debug_db_queries') . " " . CruderPdo::$query_count . " " . lang('debug_pcs') . "<br><br>";
        }
        if (self::$debug_helper) {
            echo self::trace(self::$debug_helper);
        }
    }
}
