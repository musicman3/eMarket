<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Lang,
    Messages,
    Pages,
    Settings,
    Valid
};
use Cruder\Db;

/**
 * Taxes
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Taxes {

    public static $routing_parameter = 'taxes';
    public $title = 'title_taxes_index';
    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $zones = FALSE;
    public static $zones_names = FALSE;
    public static $value_6 = FALSE;
    public static $value_4 = FALSE;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->add();
        $this->edit();
        $this->delete();
        $this->data();
        $this->modal();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=taxes', 'bi-percent', lang('title_taxes_index'), '', 'false'];
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $tax_type = 0;
            $fixed = 0;

            if (Valid::inPOST('tax_type')) {
                $tax_type = 1;
            }

            if (Valid::inPOST('fixed')) {
                $fixed = 1;
            }

            $id_max = Db::connect()
                    ->read(TABLE_TAXES)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->create(TABLE_TAXES)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_taxes_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('rate', Valid::inPOST('rate_taxes'))
                        ->set('tax_type', $tax_type)
                        ->set('zones_id', Valid::inPOST('zones_id'))
                        ->set('fixed', $fixed)
                        ->set('currency', Settings::currencyDefault()[0])
                        ->save();
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    private function edit(): void {
        if (Valid::inPOST('edit')) {

            $tax_type = 0;
            $fixed = 0;

            if (Valid::inPOST('tax_type')) {
                $tax_type = 1;
            }

            if (Valid::inPOST('fixed')) {
                $fixed = 1;
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->update(TABLE_TAXES)
                        ->set('name', Valid::inPOST('name_taxes_' . $x))
                        ->set('rate', Valid::inPOST('rate_taxes'))
                        ->set('tax_type', $tax_type)
                        ->set('zones_id', Valid::inPOST('zones_id'))
                        ->set('fixed', $fixed)
                        ->set('currency', Settings::currencyDefault()[0])
                        ->where('id=', Valid::inPOST('edit'))
                        ->and('language=', lang('#lang_all')[$x])
                        ->save();
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            Db::connect()
                    ->delete(TABLE_TAXES)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$zones = Db::connect()
                ->read(TABLE_ZONES)
                ->selectAssoc('*')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$zones_names = [];
        foreach (self::$zones as $zones_val) {
            self::$zones_names[$zones_val['id']] = $zones_val['name'];
        }

        self::$value_6 = [0 => sprintf(lang('taxes_value'), Settings::currencyDefault()[2]), 1 => lang('taxes_percent')];
        self::$value_4 = [0 => lang('taxes_separately'), 1 => lang('taxes_included')];

        self::$sql_data = Db::connect()
                ->read(TABLE_TAXES)
                ->selectAssoc('*')
                ->orderByDesc('id')
                ->save();

        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::data($lines);
    }

    /**
     * Modal
     *
     */
    private function modal(): void {
        self::$json_data = json_encode([]);
        $name = [];
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $rate[$modal_id] = round((float) $sql_modal['rate'], 2);
                        $tax_type_modal[$modal_id] = (int) $sql_modal['tax_type'];
                        $zones_id[$modal_id] = (int) $sql_modal['zones_id'];
                        $fixed_modal[$modal_id] = (int) $sql_modal['fixed'];
                    }
                }

                ksort($name);
                self::$json_data = json_encode([
                    'name' => $name,
                    'rate' => $rate,
                    'tax_type' => $tax_type_modal,
                    'zones_id' => $zones_id,
                    'fixed' => $fixed_modal,
                    'zones' => self::$zones,
                    'currency' => Settings::currencyDefault()[3]
                ]);
            }
        }
    }

}
