<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Navigation,
    Settings,
};
use eMarket\Admin\Stock;

/**
 * Pages
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Pages {

    public static $table = FALSE;
    public static $start = FALSE;
    public static $finish = FALSE;
    public static $count = FALSE;

    /**
     * Counter for Stock
     *
     * @return int Counter
     */
    public static function counterStock(): int {

        if (Stock::$finish == Stock::$count_lines_merge && (Stock::$finish - Stock::$start) <= Settings::linesOnPage() OR Stock::$finish == Settings::linesOnPage()) {
            return Stock::$finish;
        }
        return Stock::$finish - 1;
    }

    /**
     * Table data
     *
     * @param array $lines Table data
     * @return array Output data
     */
    public static function data(array $lines): array {

        if (self::$count == FALSE) {
            self::$count = count($lines);
        }

        $navigate = Navigation::data(self::$count, (int) Settings::linesOnPage());
        self::$start = $navigate[0];
        self::$finish = $navigate[1];

        $line = [];
        if (self::$count > 0) {
            $line = $lines[self::$start];
        }

        self::$table = [
            'lines' => $lines,
            'line' => $line,
            'navigate' => $navigate
        ];

        return self::$table;
    }

    /**
     * Line update
     *
     */
    public static function lineUpdate(): void {
        if (isset(self::$table['lines'][self::$start])) {
            self::$table['line'] = self::$table['lines'][self::$start];
        }
    }

    /**
     * Counter
     *
     * @return string (output data)
     */
    public static function counterPage(): string {
        $count = self::$table['navigate'][0] + 1;

        if (self::$count > 0) {
            return lang('with') . ' ' . $count . ' ' . lang('to') . ' ' . self::$table['navigate'][1] . ' ( ' . lang('of') . ' ' . self::$count . ')';
        }
        return lang('no_listing');
    }

    /**
     * Counter for Stock
     *
     * @return string (output data)
     */
    public static function counterPageStock(): string {
        $count = Stock::$start + 1;

        if (Stock::$count_lines_merge > 0) {
            return lang('with') . ' ' . $count . ' ' . lang('to') . ' ' . self::counterStock() . ' ( ' . lang('of') . ' ' . Stock::$count_lines_merge . ')';
        }
        return lang('no_listing');
    }

    /**
     * Left button
     *
     * @return string (disabled style)
     */
    public static function leftButton(): string {
        $output = 'disabled';
        if (self::$start > 0) {
            $output = '';
        }
        return $output;
    }

    /**
     * Right button
     *
     * @return string (disabled style)
     */
    public static function rightButton(): string {
        $output = 'disabled';
        if (self::$finish != self::$count) {
            $output = '';
        }
        return $output;
    }

}
