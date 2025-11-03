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
use R2D2\R2\Valid;

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

    /**
     * Add "selected" attribute
     *
     * @param string $data data
     * @param string $value value
     * @return string|bool
     */
    public static function selectedAttr(string $data, string|int $value = 1): string|bool {

        if ($data == (string) $value) {
            return 'selected';
        }
        return false;
    }

    /**
     * Class for sorties
     *
     * @param string $class Bootstrap class
     * @return string
     */
    public static function sortiesClass(string $class): string {

        if (Valid::inGET('search')) {
            return $class;
        }
        return '';
    }

    /**
     * Switching class when changing status
     *
     * @param int|string $status Status from DB
     * @param mixed $argument_1 Argument to compare
     * @param mixed $argument_2 Argument to compare
     * @param string $class Bootstrap class
     * @param string $class_2 Bootstrap class
     * @return string
     */
    public static function statusSwitchClass(int|string $status, mixed $argument_1 = null, mixed $argument_2 = null, string $class = '', string $class_2 = 'table-danger'): ?string {

        if ($argument_1 == null) {
            $arg_1 = null;
        } elseif ($argument_1 != null && $argument_1[0] >= $argument_1[1]) {
            $arg_1 = 'true';
        } else {
            $arg_1 = 'false';
        }

        if ($argument_2 == null) {
            $arg_2 = null;
        } elseif ($argument_2 != null && $argument_2[0] >= $argument_2[1]) {
            $arg_2 = 'true';
        } else {
            $arg_2 = 'false';
        }

        if ($status == 0 OR $arg_1 == 'false' OR $arg_2 == 'false') {
            return $class_2;
        } else {
            return $class;
        }
    }

    /**
     * Active tab
     *
     * @param string|int $active_tab Active tab
     * @param string|int $active Active marker
     * @param string $class Bootstrap class
     * @return string
     */
    public static function activeTab(string|int $active_tab, string|int $active = 0, string $class = 'show in active'): ?string {

        if ($active_tab == $active) {
            return $class;
        }
        return '';
    }
}
