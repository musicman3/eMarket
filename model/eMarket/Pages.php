<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для навигации и сопутствующих элементов
 *
 * @package Navigation
 * @author eMarket
 * 
 */
class Pages {

    public static $table = FALSE;
    public static $start = 0;
    public static $finish = 0;
    public static $count = FALSE;

    /**
     * НАВИГАЦИОННЫЙ СЧЕТЧИК
     *
     * @param string $start ($start)
     * @param string $finish ($finish)
     * @param string $count_lines_merge ($count_lines_merge)
     * @return string $lines_on_page(значение на выходе)
     */
    public static function counter($start, $finish, $count_lines_merge, $lines_on_page) {

        if ($finish == $count_lines_merge && ($finish - $start) <= $lines_on_page OR $finish == $lines_on_page) {
            return $finish;
        } else {
            return $finish - 1;
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

        $navigate = \eMarket\Navigation::getLink(self::$count, \eMarket\Settings::linesOnPage());
        self::$start = $navigate[0];
        self::$finish = $navigate[1];

        self::$table = [
            'lines' => $lines,
            'line' => $lines[self::$start],
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

        if (self::$count > 0) {
            return \lang('with') . ' ' . self::$start + 1 . ' ' . \lang('to') . ' ' . self::$finish . ' ( ' . \lang('of') . ' ' . self::$count . ')';
        } else {
            return \lang('no_listing');
        }
    }

}

?>