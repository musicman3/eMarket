<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Ecb,
    Pdo,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Dashboard
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Dashboard {

    public static $dashboard_orders = FALSE;
    public static $min_year = FALSE;
    public static $select_year = FALSE;
    public static $json_data = FALSE;
    public static $orders_quantity = FALSE;
    public static $amount_of_orders = FALSE;
    public static $average_check = 0;
    public static $day_of_week = FALSE;
    public static $customers = FALSE;
    public static $repeat_orders = [];

    /**
     * Constructor
     *
     */
    function __construct() {
        self::cardOrdersData();
        self::jsonData();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_market][] = ['?route=dashboard', 'bi-pie-chart-fill', lang('menu_dashboard'), '', 'false'];
    }

    /**
     * Dashboard Orders
     *
     * @return mixed Data
     */
    public static function orders(): mixed {
        if (self::$dashboard_orders == FALSE) {
            self::$dashboard_orders = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDERS . " ORDER BY id DESC LIMIT 0,5", []);
        }
        return self::$dashboard_orders;
    }

    /**
     * Min Year
     *
     * @return mixed Min Year
     */
    public static function minYear(): mixed {
        if (self::$min_year == FALSE) {
            $min_clients_id = Pdo::getValue("SELECT MIN(id) FROM " . TABLE_CUSTOMERS, []);

            if ($min_clients_id != FALSE) {
                $min_clients = Pdo::getValue("SELECT YEAR(date_account_created) FROM " . TABLE_CUSTOMERS . " WHERE id=" . $min_clients_id, []);
            } else {
                $min_clients = date('Y');
            }

            self::$min_year = $min_clients;
        }
        return self::$min_year;
    }

    /**
     * Select Year
     *
     * @return mixed Select Year
     */
    public static function selectYear(): mixed {
        if (!Valid::inPostJson('year')) {
            self::$select_year = date('Y');
        } else {
            self::$select_year = Valid::inPostJson('year');
        }
        return self::$select_year;
    }

    /**
     * Selected Year
     *
     * @param string|int $year Year
     * @return string Selected Year
     */
    public static function selectedYear(string|int $year): ?string {
        if (Valid::inPostJson('year') == $year) {
            return ' selected';
        } else {
            return '';
        }
    }

    /**
     * Orders data
     * 
     * @return array Orders data
     */
    public static function cardOrdersData(): void {

        $year = self::selectYear();
        $orders = Pdo::getAssoc("SELECT email, order_total, DAYOFWEEK(date_purchased), MONTH(date_purchased), YEAR(date_purchased) FROM " . TABLE_ORDERS . " WHERE YEAR(date_purchased) = " . $year, []);

        $month_count = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $month_amount = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $day_count = [0, 0, 0, 0, 0, 0, 0];
        $emails = [];
        $emails_doubles = [];
        foreach ($orders as $orders_value) {
            $json_decode_month_amount = json_decode($orders_value['order_total'], true);
            $total_to_pay = $json_decode_month_amount['data']['total_to_pay'];
            $order_currency = $json_decode_month_amount['data']['currency'];

            for ($x = 0; $x < 7; $x++) {
                if ($orders_value['DAYOFWEEK(date_purchased)'] == $x + 1) {
                    $day_count[$x]++;
                }
            }

            for ($x = 0; $x < 12; $x++) {
                if ($orders_value['MONTH(date_purchased)'] == $x + 1) {
                    $month_count[$x]++;
                    $month_amount[$x] = $month_amount[$x] + Ecb::currencyPrice($total_to_pay, $order_currency);
                }
            }

            if (!in_array($orders_value['email'], $emails)) {
                array_push($emails, $orders_value['email']);
            } elseif (!in_array($orders_value['email'], $emails_doubles)) {
                array_push($emails_doubles, $orders_value['email']);
            }
        }

        $orders_count = count($orders);
        self::$orders_quantity = [
            'titleText' => lang('dashboard_total') . ' ' . $orders_count,
            'legendData' => [lang('dashboard_orders_quantity')],
            'xAxisData' => [
                lang('dashboard_jan'), lang('dashboard_feb'), lang('dashboard_mar'), lang('dashboard_apr'),
                lang('dashboard_may'), lang('dashboard_jun'), lang('dashboard_jul'), lang('dashboard_aug'),
                lang('dashboard_sep'), lang('dashboard_oct'), lang('dashboard_nov'), lang('dashboard_dec')
            ],
            'seriesName' => lang('dashboard_orders_quantity'),
            'seriesData' => $month_count
        ];

        $amount_count = 0;
        foreach ($month_amount as $key => $value) {
            $amount_count = $amount_count + $value;
            $month_amount[$key] = round($value, 2);
        }

        self::$amount_of_orders = [
            'titleText' => lang('dashboard_total') . ' ' . Ecb::formatPrice($amount_count, 1),
            'legendData' => [lang('dashboard_proceeds')],
            'xAxisData' => [
                lang('dashboard_jan'), lang('dashboard_feb'), lang('dashboard_mar'), lang('dashboard_apr'),
                lang('dashboard_may'), lang('dashboard_jun'), lang('dashboard_jul'), lang('dashboard_aug'),
                lang('dashboard_sep'), lang('dashboard_oct'), lang('dashboard_nov'), lang('dashboard_dec')
            ],
            'seriesName' => lang('dashboard_proceeds'),
            'seriesData' => $month_amount
        ];

        if ($orders_count > 0) {
            self::$average_check = Ecb::formatPrice($amount_count / $orders_count, 1);
        } else {
            self::$average_check = Ecb::formatPrice(0, 1);
        }

        self::$day_of_week = [
            'titleText' => '',
            'legendData' => [lang('dashboard_orders_by_day_of_the_week')],
            'xAxisData' => [
                lang('dashboard_sun'), lang('dashboard_mon'), lang('dashboard_tue'), lang('dashboard_wed'),
                lang('dashboard_thu'), lang('dashboard_fri'), lang('dashboard_sat')
            ],
            'seriesName' => lang('dashboard_orders_by_day_of_the_week'),
            'seriesData' => $day_count
        ];

        $emails_uniq = array_diff($emails, $emails_doubles);
        $emails_count = count($emails_uniq);
        self::$repeat_orders = [
            'titleText' => '',
            'legendData' => [],
            'seriesName' => lang('dashboard_orders_from_customers'),
            'seriesData' =>
            [
                ['value' => $orders_count - $emails_count,
                    'name' => lang('dashboard_repeat')
                ],
                ['value' => $emails_count,
                    'name' => lang('dashboard_new')
                ]
            ]
        ];
    }

    /**
     * Customers data
     *
     * @return mixed Customers data
     */
    public static function customersData(): mixed {
        if (self::$customers == FALSE) {
            self::$customers = Pdo::getAssoc("SELECT id FROM " . TABLE_CUSTOMERS . " WHERE YEAR(date_account_created) = " . self::selectYear(), []);
        }
        return self::$customers;
    }

    /**
     * JSON data
     *
     */
    public static function jsonData(): void {
        self::$json_data = json_encode([
            'cardWeekDays' => self::$day_of_week,
            'cardOrdersQuantity' => self::$orders_quantity,
            'cardAmountOfOrders' => self::$amount_of_orders,
            'cardNewOldOrders' => self::$repeat_orders
        ]);
    }

}
