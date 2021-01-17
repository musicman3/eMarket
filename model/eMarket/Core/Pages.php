<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

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

        if (\eMarket\Admin\Stock::$finish == \eMarket\Admin\Stock::$count_lines_merge && (\eMarket\Admin\Stock::$finish - \eMarket\Admin\Stock::$start) <= \eMarket\Core\Settings::linesOnPage() OR \eMarket\Admin\Stock::$finish == \eMarket\Core\Settings::linesOnPage()) {
            return \eMarket\Admin\Stock::$finish;
        } else {
            return \eMarket\Admin\Stock::$finish - 1;
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
        
        $navigate = \eMarket\Core\Navigation::getLink(self::$count, \eMarket\Core\Settings::linesOnPage());
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
        $count = self::$start + 1;

        if (self::$count > 0) {
            return lang('with') . ' ' . $count . ' ' . lang('to') . ' ' . self::$finish . ' ( ' . lang('of') . ' ' . self::$count . ')';
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
        $count = \eMarket\Admin\Stock::$start + 1;

        if (\eMarket\Admin\Stock::$count_lines_merge > 0) {
            return lang('with') . ' ' . $count . ' ' . lang('to') . ' ' . self::counterStock() . ' ( ' . lang('of') . ' ' . \eMarket\Admin\Stock::$count_lines_merge . ')';
        } else {
            return lang('no_listing');
        }
    }

}

?>