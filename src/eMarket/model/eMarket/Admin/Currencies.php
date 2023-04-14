<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Clock\SystemClock,
    Func,
    Lang,
    Pages,
    Valid,
    Messages
};
use Cruder\Cruder;

/**
 * Currencies
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Currencies {

    public static $routing_parameter = 'currencies';
    public $title = 'title_currencies_index';
    public $db;
    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public int $default = 0;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->db = new Cruder();
        $this->default();
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
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=currencies', 'bi-cash', lang('title_currencies_index'), '', 'false'];
    }

    /**
     * Default
     *
     */
    private function default(): void {
        if (Valid::inPOST('default_value_currencies')) {
            $this->default = 1;
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = $this->db
                    ->read(TABLE_CURRENCIES)
                    ->selectGetValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {
                $this->recount();
                $this->addAction($id, 1);
            } else {
                $this->addAction($id, Valid::inPOST('value_currencies'));
            }

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Add action
     *
     * @param int|string $id ID
     * @param int|string $value Value
     */
    private function addAction(int|string $id, int|string $value): void {
        for ($x = 0; $x < Lang::$count; $x++) {

            $this->db
                    ->create(TABLE_CURRENCIES)
                    ->set('id', $id)
                    ->set('name', Valid::inPOST('name_currencies_' . $x))
                    ->set('language', lang('#lang_all')[$x])
                    ->set('code', Valid::inPOST('code_currencies_' . $x))
                    ->set('iso_4217', Valid::inPOST('iso_4217_currencies'))
                    ->set('value', $value)
                    ->set('default_value', $this->default)
                    ->set('symbol', Valid::inPOST('symbol_currencies'))
                    ->set('symbol_position', Valid::inPOST('symbol_position_currencies'))
                    ->set('decimal_places', Valid::inPOST('decimal_places_currencies'))
                    ->save();
        }
    }

    /**
     * Edit
     *
     */
    private function edit(): void {
        if (Valid::inPOST('edit')) {

            if ($this->default != 0) {

                $this->db
                        ->update(TABLE_CURRENCIES)
                        ->set('default_value', 0)
                        ->save();

                $this->recount();
                $this->editAction(1);
            } else {
                $this->editAction(Valid::inPOST('value_currencies'));
            }

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit action
     *
     * @param int|string $value Value
     */
    private function editAction(int|string $value): void {
        for ($x = 0; $x < Lang::$count; $x++) {

            $this->db
                    ->update(TABLE_CURRENCIES)
                    ->set('name', Valid::inPOST('name_currencies_' . $x))
                    ->set('code', Valid::inPOST('code_currencies_' . $x))
                    ->set('iso_4217', Valid::inPOST('iso_4217_currencies'))
                    ->set('value', $value)
                    ->set('default_value', $this->default)
                    ->set('symbol', Valid::inPOST('symbol_currencies'))
                    ->set('symbol_position', Valid::inPOST('symbol_position_currencies'))
                    ->set('decimal_places', Valid::inPOST('decimal_places_currencies'))
                    ->set('last_updated', SystemClock::nowSqlDateTime())
                    ->where('id=', Valid::inPOST('edit'))
                    ->and('language=', lang('#lang_all')[$x])
                    ->save();
        }
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            $this->db
                    ->delete(TABLE_CURRENCIES)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Recount
     *
     */
    private function recount(): void {

        $this->db
                ->update(TABLE_CURRENCIES)
                ->set('default_value', 0)
                ->save();

        $data = $this->db
                ->read(TABLE_CURRENCIES)
                ->selectGetAssoc('*')
                ->save();

        foreach ($data as $value) {

            $this->db
                    ->update(TABLE_CURRENCIES)
                    ->set('value', $value['value'] / Valid::inPOST('value_currencies'))
                    ->where('id=', $value['id'])
                    ->and('language=', $value['language'])
                    ->save();
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {

        self::$sql_data = $this->db
                ->read(TABLE_CURRENCIES)
                ->selectGetAssoc('*')
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
        $code = [];
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {

                    if ($sql_modal['id'] == $modal_id) {
                        $name[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['name'];
                        $code[array_search($sql_modal['language'], lang('#lang_all'))][$modal_id] = $sql_modal['code'];
                    }
                    if ($sql_modal['language'] == lang('#lang_all')[0] && $sql_modal['id'] == $modal_id) {
                        $iso_4217[$modal_id] = $sql_modal['iso_4217'];
                        $value[$modal_id] = (float) $sql_modal['value'];
                        $symbol[$modal_id] = $sql_modal['symbol'];
                        $symbol_position[$modal_id] = $sql_modal['symbol_position'];
                        $decimal_places[$modal_id] = (float) $sql_modal['decimal_places'];
                        $status[$modal_id] = (int) $sql_modal['default_value'];
                    }
                }

                ksort($name);
                ksort($code);

                self::$json_data = json_encode([
                    'name' => $name,
                    'code' => $code,
                    'iso_4217' => $iso_4217,
                    'value' => $value,
                    'symbol' => $symbol,
                    'symbol_position' => $symbol_position,
                    'decimal_places' => $decimal_places,
                    'default_value' => $status
                ]);
            }
        }
    }

    /**
     * Default text
     *
     * @return string Output text
     */
    public static function defaultText(): string {
        $output = lang('confirm-no');
        if (Pages::$table['line']['default_value'] == 1) {
            $output = lang('confirm-yes');
        }
        return $output;
    }

}
