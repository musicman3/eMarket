<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Clock\SystemClock,
    Ecb,
    Valid
};
use eMarket\Admin\HeaderMenu;
use Cruder\Db;

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

    public static $routing_parameter = 'dashboard';
    public $title = 'title_dashboard_index';
    public $db_functions;
    public $orders_quantity = FALSE;
    public $amount_of_orders = FALSE;
    public $day_of_week = FALSE;
    public $repeat_orders = [];
    public static $min_year = FALSE;
    public static $json_data = FALSE;
    public static $average_check = 0;
    public static $customers = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        Valid::$demo_mode = FALSE;
        $this->cardOrdersData();
        $this->jsonData();
        $this->customersData();
        $this->minYear();
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
     * Selected Year
     *
     * @param string|int $year Year
     * @return string Selected Year
     */
    public static function selectedYear(string|int $year): ?string {
        $output = '';
        if (Valid::inPostJson('year') == $year) {
            $output = ' selected';
        }
        return $output;
    }

    /**
     * Min Year
     *
     */
    private function minYear(): void {
        if (self::$min_year == FALSE) {

            $min_clients_id = Db::connect()
                    ->read(TABLE_CUSTOMERS)
                    ->selectValue('{{MIN->id}}')
                    ->save();

            $min_clients = SystemClock::nowFormatDate('Y');

            if ($min_clients_id != FALSE) {
                $min_clients = Db::connect()
                        ->read(TABLE_CUSTOMERS)
                        ->selectValue('{{YEAR->date_account_created}}')
                        ->where('id=', $min_clients_id)
                        ->save();
            }

            self::$min_year = $min_clients;
        }
    }

    /**
     * Select Year
     *
     * @return mixed Select Year
     */
    private function selectYear(): mixed {
        $select_year = SystemClock::nowFormatDate('Y');
        if (Valid::inPostJson('year')) {
            $select_year = Valid::inPostJson('year');
        }
        return $select_year;
    }

    /**
     * Orders data
     * 
     * @return array Orders data
     */
    private function cardOrdersData(): void {

        $year = self::selectYear();

        $orders = Db::connect()
                ->read(TABLE_ORDERS)
                ->selectIndex('email, order_total, {{DAYOFWEEK->date_purchased}}, {{MONTH->date_purchased}}')
                ->where('{{YEAR->date_purchased}}=', $year)
                ->save();

        $month_count = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $month_amount = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $day_count = [0, 0, 0, 0, 0, 0, 0];
        $emails = [];
        $emails_doubles = [];
        foreach ($orders as $orders_value) {
            $json_decode_month_amount = json_decode($orders_value[1], true);
            $total_to_pay = $json_decode_month_amount['data']['total_to_pay'];
            $order_currency = $json_decode_month_amount['data']['currency'];

            for ($x = 0; $x < 7; $x++) {
                if ($orders_value[2] == $x + 1) {
                    $day_count[$x]++;
                }
            }

            for ($x = 0; $x < 12; $x++) {
                if ($orders_value[3] == $x + 1) {
                    $month_count[$x]++;
                    $month_amount[$x] = $month_amount[$x] + Ecb::currencyPrice($total_to_pay, $order_currency);
                }
            }

            if (!in_array($orders_value[0], $emails)) {
                array_push($emails, $orders_value[0]);
            } elseif (!in_array($orders_value[0], $emails_doubles)) {
                array_push($emails_doubles, $orders_value[0]);
            }
        }

        $orders_count = count($orders);
        $this->orders_quantity = [
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

        $this->amount_of_orders = [
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

        $this->day_of_week = [
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
        $this->repeat_orders = [
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
     */
    private function customersData(): void {
        if (self::$customers == FALSE) {

            self::$customers = Db::connect()
                    ->read(TABLE_CUSTOMERS)
                    ->selectAssoc('id')
                    ->where('{{YEAR->date_account_created}}=', $this->selectYear())
                    ->save();
        }
    }

    /**
     * JSON data
     *
     */
    private function jsonData(): void {
        self::$json_data = json_encode([
            'cardWeekDays' => $this->day_of_week,
            'cardOrdersQuantity' => $this->orders_quantity,
            'cardAmountOfOrders' => $this->amount_of_orders,
            'cardNewOldOrders' => $this->repeat_orders
        ]);
    }
}
