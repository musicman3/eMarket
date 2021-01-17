<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

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
            return array($start, $finish + $transfer);
        }

        if ($start == 0 && $count_lines >= $lines_on_page + $transfer && $transfer != null) {
            $finish = $finish + $transfer;
        }

        if (\eMarket\Core\Valid::inGET('finish')) {
            $finish = \eMarket\Core\Valid::inGET('finish') + $lines_on_page;
            $start = \eMarket\Core\Valid::inGET('start') + $lines_on_page;
            if ($start >= $count_lines) {
                $start = \eMarket\Core\Valid::inGET('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
            return array($start, $finish);
        }

        if ($count_lines > $lines_on_page && \eMarket\Core\Valid::inGET('backfinish')) {
            $finish = \eMarket\Core\Valid::inGET('backstart');
            $start = \eMarket\Core\Valid::inGET('backstart') - $lines_on_page;
            if ($start < 0) {
                $start = 0;
            }
            if ($finish < $lines_on_page) {
                $finish = $lines_on_page;
            }
            return array($start, $finish + $transfer);
        }

        return array($start, $finish);
    }

    /**
     * Post navigation
     *
     * @param string $count_lines Number of lines per page
     * @param string $lines_on_page Max of lines per page
     * @param string $transfer Transfer
     * @return array
     */
    public static function postLink($count_lines, $lines_on_page, int $transfer = null) {

        $start = 0;
        $finish = $lines_on_page;

        if ($count_lines <= $lines_on_page) {
            $finish = $count_lines;
        }

        if ($start == 0 && $finish >= $lines_on_page + $transfer && $transfer != null) {
            return array($start, $finish + $transfer);
        }

        if ($start == 0 && $count_lines >= $lines_on_page + $transfer && $transfer != null) {
            $finish = $finish + $transfer;
        }

        if (\eMarket\Core\Valid::inPOST('finish')) {
            $finish = \eMarket\Core\Valid::inPOST('finish') + $lines_on_page;
            $start = \eMarket\Core\Valid::inPOST('start') + $lines_on_page;
            if ($start >= $count_lines) {
                $start = \eMarket\Core\Valid::inPOST('start');
            }
            if ($finish >= $count_lines) {
                $finish = $count_lines;
            }
            return array($start, $finish);
        }

        if ($count_lines > $lines_on_page && \eMarket\Core\Valid::inPOST('backfinish')) {
            $finish = \eMarket\Core\Valid::inPOST('backstart');
            $start = \eMarket\Core\Valid::inPOST('backstart') - $lines_on_page;
            if ($start < 0) {
                $start = 0;
            }
            if ($finish < $lines_on_page) {
                $finish = $lines_on_page;
            }
            return array($start, $finish + $transfer);
        }

        return array($start, $finish);
    }

}
