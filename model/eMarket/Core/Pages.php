<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use \eMarket\Core\{
    Navigation,
    Settings,
};
use \eMarket\Admin\Stock;

/**
 * Pages
 *
 * @package Pages
 * @author eMarket
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
     */
    public static function counterStock() {

        if (Stock::$finish == Stock::$count_lines_merge && (Stock::$finish - Stock::$start) <= Settings::linesOnPage() OR Stock::$finish == Settings::linesOnPage()) {
            return Stock::$finish;
        } else {
            return Stock::$finish - 1;
        }
    }

    /**
     * Table data
     *
     * @param array $lines (table data)
     * @return array (output data)
     */
    public static function table($lines) {

        if (self::$count == FALSE) {
            self::$count = count($lines);
        }

        $navigate = Navigation::getLink(self::$count, Settings::linesOnPage());
        self::$start = $navigate[0];
        self::$finish = $navigate[1];

        if (self::$count > 0) {
            $line = $lines[self::$start];
        } else {
            $line = [];
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
    public static function lineUpdate() {
        if (isset(self::$table['lines'][self::$start])) {
            self::$table['line'] = self::$table['lines'][self::$start];
        }
    }

    /**
     * Counter
     *
     * @return string (output data)
     */
    public static function counterPage() {
        $count = self::$table['navigate'][0] + 1;

        if (self::$count > 0) {
            return lang('with') . ' ' . $count . ' ' . lang('to') . ' ' . self::$table['navigate'][1] . ' ( ' . lang('of') . ' ' . self::$count . ')';
        } else {
            return lang('no_listing');
        }
    }

    /**
     * Counter
     *
     * @return string (output data)
     */
    public static function counterPageStock() {
        $count = Stock::$start + 1;

        if (Stock::$count_lines_merge > 0) {
            return lang('with') . ' ' . $count . ' ' . lang('to') . ' ' . self::counterStock() . ' ( ' . lang('of') . ' ' . Stock::$count_lines_merge . ')';
        } else {
            return lang('no_listing');
        }
    }

}

?>