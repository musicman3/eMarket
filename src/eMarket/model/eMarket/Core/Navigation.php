<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Valid
};

/**
 * Navigation
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Navigation {

    /**
     * Get navigation
     *
     * @param int $count_lines Number of lines per page
     * @param int $lines_on_page Max of lines per page
     * @param int $transfer Transfer
     * @return array Start & finish pages
     */
    public static function data(int $count_lines, int $lines_on_page, int $transfer = null): array {

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
