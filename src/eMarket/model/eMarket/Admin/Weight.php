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
    Valid,
};
use Cruder\Db;

/**
 * Weight
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Weight {

    public static $routing_parameter = 'weight';
    public $title = 'title_weight_index';
    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public int $default = 0;

    /**
     * Constructor
     *
     */
    function __construct() {
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
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=weight', 'bi-minecart-loaded', lang('title_weight_index'), '', 'false'];
    }

    /**
     * Default
     *
     */
    private function default(): void {
        if (Valid::inPOST('default_weight')) {
            $this->default = 1;
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {

            $id_max = Db::connect()
                    ->read(TABLE_WEIGHT)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {
                $this->recount();
                $this->addAction($id, 1);
            } else {
                $this->addAction($id, Valid::inPOST('value_weight'));
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

            Db::connect()
                    ->create(TABLE_WEIGHT)
                    ->set('id', $id)
                    ->set('name', Valid::inPOST('name_weight_' . $x))
                    ->set('language', lang('#lang_all')[$x])
                    ->set('code', Valid::inPOST('code_weight_' . $x))
                    ->set('value_weight', $value)
                    ->set('default_weight', $this->default)
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
                $this->recount();
                $this->editAction(1);
            } else {
                $this->editAction(Valid::inPOST('value_weight'));
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

            Db::connect()
                    ->update(TABLE_WEIGHT)
                    ->set('name', Valid::inPOST('name_weight_' . $x))
                    ->set('code', Valid::inPOST('code_weight_' . $x))
                    ->set('value_weight', $value)
                    ->set('default_weight', $this->default)
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

            Db::connect()
                    ->delete(TABLE_WEIGHT)
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

        Db::connect()
                ->update(TABLE_WEIGHT)
                ->set('default_weight', 0)
                ->save();

        $data = Db::connect()
                ->read(TABLE_WEIGHT)
                ->selectAssoc('*')
                ->save();

        foreach ($data as $value) {

            Db::connect()
                    ->update(TABLE_WEIGHT)
                    ->set('value_weight', $value['value_weight'] / Valid::inPOST('value_weight'))
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

        self::$sql_data = Db::connect()
                ->read(TABLE_WEIGHT)
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
                        $value[$modal_id] = (float) $sql_modal['value_weight'];
                        $status[$modal_id] = (int) $sql_modal['default_weight'];
                    }
                }

                ksort($name);
                ksort($code);

                self::$json_data = json_encode([
                    'name' => $name,
                    'code' => $code,
                    'value' => $value,
                    'status' => $status
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
        if (Pages::$table['line']['default_weight'] == 1) {
            $output = lang('confirm-yes');
        }
        return $output;
    }

}
