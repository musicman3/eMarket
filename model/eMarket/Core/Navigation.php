<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use \eMarket\Core\{
    Valid
};

/**
 * Navigation
 *
 * @package Navigation
 * @author eMarket
 * 
 */
class Navigation {

    /**
     * Get navigation
     *
     * @param string $count_lines Number of lines per page
     * @param string $lines_on_page Max of lines per page
     * @param string $transfer Transfer
     * @return array
     */
    public static function getLink($count_lines, $lines_on_page, int $transfer = null) {

        $start = 0;
        $finish = $lines_on_page;

        if ($count_lines <= $lines_on_page) {
            $finish = $count_lines;
        }

        if ($start == 0 && $finish >= $lines_on_page + $transfer && $transfer != null) {
            return [$start, $finish + $transfer];
        }

        if ($start == 0 && $count_lines >= $lines_on_page + $transfer && $transfer != null) {
            $finish = $finish + $transfer;
        }

        if (Valid::inGET('finish')) {
            $finish = Valid::inGET('finish') + $lines_on_page;
            $start = Valid::inGET('start') + $lines_on_page;
            if ($start >= $count_lines) {
                $start = Valid::inGET('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
            return [$start, $finish];
        }

        if ($count_lines > $lines_on_page && Valid::inGET('backfinish')) {
            $finish = Valid::inGET('backstart');
            $start = Valid::inGET('backstart') - $lines_on_page;
            if ($start < 0) {
                $start = 0;
            }
            if ($finish < $lines_on_page) {
                $finish = $lines_on_page;
            }
            return [$start, $finish + $transfer];
        }

        return [$start, $finish];
    }

}
