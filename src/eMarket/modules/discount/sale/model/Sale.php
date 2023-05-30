<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules\Discount;

use eMarket\Core\{
    Cache,
    Clock\SystemClock,
    Ecb,
    Func,
    DataBuffer,
    Interfaces\DiscountModulesInterface,
    Lang,
    Messages,
    Modules,
    Pages,
    Valid
};
use eMarket\Admin\{
    HeaderMenu,
    Eac
};
use Cruder\Db;

/**
 * Module Sale
 *
 * @package Discount modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Sale implements DiscountModulesInterface {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $this_time = FALSE;
    public int $default = 0;
    public $start_date = NULL;
    public $end_date = NULL;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->default();
        $this->startDate();
        $this->endDate();
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
        HeaderMenu::$menu[HeaderMenu::$menu_marketing][] = ['?route=modules/edit&type=discount&name=sale&alias=true', 'bi-star', lang('modules_discount_sale_name'), '', 'false'];
    }

    /**
     * Install
     *
     * @param array $module (input data)
     */
    public static function install(array $module): void {
        Modules::install($module);
    }

    /**
     * Delete
     *
     * @param array $module (input data)
     */
    public static function uninstall(array $module): void {
        Modules::uninstall($module);

        $products_data = Db::connect()
                ->read(TABLE_PRODUCTS)
                ->selectAssoc('id, discount')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        foreach ($products_data as $data) {
            $discounts = json_decode($data['discount'], true);
            unset($discounts['sale']);

            Db::connect()
                    ->update(TABLE_PRODUCTS)
                    ->set('discount', json_encode($discounts))
                    ->where('id=', $data['id'])
                    ->save();
        }
    }

    /**
     * Default
     *
     */
    public function default(): void {
        if (Valid::inPOST('default_module')) {
            $this->default = 1;
        }
    }

    /**
     * Default text
     *
     * @return string Output text
     */
    public static function defaultText(): string {
        $output = lang('confirm-no');
        if (Pages::$table['line']['default_set'] == 1) {
            $output = lang('confirm-yes');
        }
        return $output;
    }

    /**
     * End date
     *
     */
    public function startDate(): void {
        if (Valid::inPOST('start_date')) {
            $this->start_date = SystemClock::getSqlDate(Valid::inPOST('start_date'));
        }
    }

    /**
     * Start date
     *
     */
    public function endDate(): void {
        if (Valid::inPOST('end_date')) {
            $this->end_date = SystemClock::getSqlDate(Valid::inPOST('end_date'));
        }
    }

    /**
     * Status
     *
     * @return mixed
     */
    public static function status(): mixed {

        $module_active = Db::connect()
                ->read(TABLE_MODULES)
                ->selectValue('active')
                ->where('name=', 'sale')
                ->and('type=', 'discount')
                ->save();

        return $module_active;
    }

    /**
     * Output data for calculation block
     *
     * @param array $input (input data)
     * @param string $language (language)
     * @return array (output data)
     */
    public static function dataInterface(array $input, ?string $language = null): void {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }

        $discount_val = json_decode($input['discount'], true);
        $currency = $input['currency'];
        $input_price = Ecb::currencyPrice($input['price'], $currency);

        $DataBuffer = new DataBuffer();

        if (is_array($discount_val) && array_key_exists('sale', $discount_val) && count($discount_val['sale']) > 0 && self::status() != FALSE && self::status() == 1) {

            $discount_out = [];
            $discount_names = [];

            foreach ($discount_val['sale'] as $val) {

                $data = Db::connect()
                                ->read(DB_PREFIX . 'modules_discount_sale')
                                ->selectAssoc('sale_value, name, date_start, date_end')
                                ->where('language=', $language)
                                ->and('id=', $val)
                                ->save()[0];

                if (count($data) > 0) {
                    $this_time = SystemClock::nowUnixTime();
                    $date_start = SystemClock::getUnixTime($data['date_start']);
                    $date_end = SystemClock::getUnixTime($data['date_end']);

                    if ($this_time > $date_start && $this_time < $date_end) {
                        array_push($discount_out, $data['sale_value']);
                        array_push($discount_names, lang('modules_discount_sale_name') . ': ' . $data['name'] . ' (' . $data['sale_value'] . '%)');
                    }
                }
            }

            $total_rate = 0;
            foreach ($discount_out as $rate) {
                $total_rate = $total_rate + $rate;
            }

            $out_price = $input_price / 100 * (100 - $total_rate);

            $out_data = [
                'price' => $out_price,
                'names' => $discount_names,
                'discounts' => $discount_out
            ];

            $DataBuffer->save('discount', 'sale', $out_data);
        } else {

            $out_data = [
                'price' => $input_price,
                'names' => 'false',
                'discounts' => 'false'
            ];

            $DataBuffer->save('discount', 'sale', $out_data);
        }
    }

    /**
     * EAC init
     */
    public static function initEac(): void {

        if ((Valid::inPostJson('idsx_sale_on_key') == 'On')
                or (Valid::inPostJson('idsx_sale_off_key') == 'Off')
                or (Valid::inPostJson('idsx_sale_off_all_key') == 'OffAll')) {

            $parent_id_real = (int) Valid::inPostJson('idsx_real_parent_id');

            if (Valid::inPostJson('idsx_sale_on_key') == 'On') {
                $idx = Func::deleteEmptyInArray(Valid::inPostJson('idsx_sale_on_id'));
                $discount = Valid::inPostJson('sale');
            }

            if (Valid::inPostJson('idsx_sale_off_key') == 'Off') {
                $idx = Func::deleteEmptyInArray(Valid::inPostJson('idsx_sale_off_id'));
                $discount = Valid::inPostJson('sale');
            }

            if (Valid::inPostJson('idsx_sale_off_all_key') == 'OffAll') {
                $idx = Func::deleteEmptyInArray(Valid::inPostJson('idsx_sale_off_all_id'));
                $discount = Valid::inPostJson('sale');
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'products') {
                    Eac::$parent_id = Eac::dataParentId($idx[$i]);
                    $keys = Eac::dataKeys($idx[$i]);
                    $count_keys = count($keys);

                    for ($x = 0; $x < $count_keys; $x++) {
                        if (Valid::inPostJson('idsx_sale_on_key') == 'On') {

                            $products_id = Db::connect()
                                    ->read(TABLE_PRODUCTS)
                                    ->selectAssoc('id')
                                    ->where('language=', lang('#lang_all')[0])
                                    ->and('parent_id=', $keys[$x])
                                    ->save();

                            foreach ($products_id as $val) {

                                $discount_json = Db::connect()
                                        ->read(TABLE_PRODUCTS)
                                        ->selectValue('discount')
                                        ->where('id=', $val['id'])
                                        ->save();

                                $discount_array = json_decode($discount_json, true);

                                if (!array_key_exists('sale', $discount_array)) {
                                    $discount_array['sale'] = [$discount];
                                } else {
                                    if (!in_array($discount, $discount_array['sale'])) {
                                        array_push($discount_array['sale'], $discount);
                                    }
                                }

                                Db::connect()
                                        ->update(TABLE_PRODUCTS)
                                        ->set('discount', json_encode($discount_array))
                                        ->where('id=', $val['id'])
                                        ->save();

                                $Cache = new Cache();
                                $Cache->deleteItem('core.new_products');
                                $Cache->deleteItem('core.products_' . $val['id']);

                                Messages::alert('sale_on', 'success', lang('action_completed_successfully'), 0, true);
                            }

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }
                        }

                        if (Valid::inPostJson('idsx_sale_off_key') == 'Off') {

                            $products_id = Db::connect()
                                    ->read(TABLE_PRODUCTS)
                                    ->selectAssoc('id')
                                    ->where('language=', lang('#lang_all')[0])
                                    ->and('parent_id=', $keys[$x])
                                    ->save();

                            foreach ($products_id as $val) {

                                $discount_json = Db::connect()
                                        ->read(TABLE_PRODUCTS)
                                        ->selectValue('discount')
                                        ->where('id=', $val['id'])
                                        ->save();

                                $discount_array = json_decode($discount_json, true);

                                if (array_key_exists('sale', $discount_array)) {
                                    foreach ($discount_array['sale'] as $key_del => $name_del) {
                                        if ($name_del == $discount) {
                                            unset($discount_array['sale'][$key_del]);
                                        }
                                    }
                                }

                                Db::connect()
                                        ->update(TABLE_PRODUCTS)
                                        ->set('discount', json_encode($discount_array))
                                        ->where('id=', $val['id'])
                                        ->save();

                                $Cache = new Cache();
                                $Cache->deleteItem('core.new_products');
                                $Cache->deleteItem('core.products_' . $val['id']);
                            }

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }

                            Messages::alert('sale_off', 'success', lang('action_completed_successfully'), 0, true);
                        }

                        if (Valid::inPostJson('idsx_sale_off_all_key') == 'OffAll') {

                            $products_id = Db::connect()
                                    ->read(TABLE_PRODUCTS)
                                    ->selectAssoc('id')
                                    ->where('language=', lang('#lang_all')[0])
                                    ->and('parent_id=', $keys[$x])
                                    ->save();

                            foreach ($products_id as $val) {

                                $discount_json = Db::connect()
                                        ->read(TABLE_PRODUCTS)
                                        ->selectValue('discount')
                                        ->where('id=', $val['id'])
                                        ->save();

                                $discount_array = json_decode($discount_json, true);

                                if (array_key_exists('sale', $discount_array)) {
                                    unset($discount_array['sale']);
                                }

                                Db::connect()
                                        ->update(TABLE_PRODUCTS)
                                        ->set('discount', json_encode($discount_array))
                                        ->where('id=', $val['id'])
                                        ->save();

                                $Cache = new Cache();
                                $Cache->deleteItem('core.new_products');
                                $Cache->deleteItem('core.products_' . $val['id']);
                            }

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }

                            Messages::alert('sale_off_all', 'success', lang('action_completed_successfully'), 0, true);
                        }
                    }
                } else {
                    if (Valid::inPostJson('idsx_sale_on_key') == 'On') {
                        $id_prod = explode('products_', $idx[$i]);

                        $discount_json = Db::connect()
                                ->read(TABLE_PRODUCTS)
                                ->selectValue('discount')
                                ->where('id=', $id_prod[1])
                                ->save();

                        $discount_array = json_decode($discount_json, true);

                        if (!array_key_exists('sale', $discount_array)) {
                            $discount_array['sale'] = [$discount];
                        } else {
                            if (!in_array($discount, $discount_array['sale'])) {
                                array_push($discount_array['sale'], $discount);
                            }
                        }

                        Db::connect()
                                ->update(TABLE_PRODUCTS)
                                ->set('discount', json_encode($discount_array))
                                ->where('id=', $id_prod[1])
                                ->save();

                        $Cache = new Cache();
                        $Cache->deleteItem('core.new_products');
                        $Cache->deleteItem('core.products_' . $id_prod[1]);

                        Messages::alert('sale_on', 'success', lang('action_completed_successfully'), 0, true);
                    }

                    if (Valid::inPostJson('idsx_sale_off_key') == 'Off') {
                        $id_prod = explode('products_', $idx[$i]);

                        $discount_json = Db::connect()
                                ->read(TABLE_PRODUCTS)
                                ->selectValue('discount')
                                ->where('id=', $id_prod[1])
                                ->save();

                        $discount_array = json_decode($discount_json, true);

                        if (array_key_exists('sale', $discount_array)) {
                            foreach ($discount_array['sale'] as $key_del => $name_del) {
                                if ($name_del == $discount) {
                                    unset($discount_array['sale'][$key_del]);
                                }
                            }
                        }

                        Db::connect()
                                ->update(TABLE_PRODUCTS)
                                ->set('discount', json_encode($discount_array))
                                ->where('id=', $id_prod[1])
                                ->save();

                        $Cache = new Cache();
                        $Cache->deleteItem('core.new_products');
                        $Cache->deleteItem('core.products_' . $id_prod[1]);

                        Messages::alert('sale_off', 'success', lang('action_completed_successfully'), 0, true);
                    }

                    if (Valid::inPostJson('idsx_sale_off_all_key') == 'OffAll') {
                        $id_prod = explode('products_', $idx[$i]);

                        $discount_json = Db::connect()
                                ->read(TABLE_PRODUCTS)
                                ->selectValue('discount')
                                ->where('id=', $id_prod[1])
                                ->save();

                        $discount_array = json_decode($discount_json, true);

                        if (array_key_exists('sale', $discount_array)) {
                            unset($discount_array['sale']);
                        }

                        Db::connect()
                                ->update(TABLE_PRODUCTS)
                                ->set('discount', json_encode($discount_array))
                                ->where('id=', $id_prod[1])
                                ->save();

                        $Cache = new Cache();
                        $Cache->deleteItem('core.new_products');
                        $Cache->deleteItem('core.products_' . $id_prod[1]);

                        Messages::alert('sale_off_all', 'success', lang('action_completed_successfully'), 0, true);
                    }
                }
            }
        }

        if (is_array(Eac::$parent_id) == TRUE) {
            Eac::$parent_id = 0;
        }
    }

    /**
     * Add
     *
     */
    public function add(): void {
        if (Valid::inPOST('add')) {

            $MODULE_DB = Modules::moduleDatabase();

            $id_max = Db::connect()
                    ->read($MODULE_DB)
                    ->selectValue('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            $id = intval($id_max) + 1;

            if ($id > 1 && $this->default != 0) {

                Db::connect()
                        ->update($MODULE_DB)
                        ->set('default_set', 0)
                        ->save();
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->create($MODULE_DB)
                        ->set('id', $id)
                        ->set('name', Valid::inPOST('name_module_' . $x))
                        ->set('language', lang('#lang_all')[$x])
                        ->set('sale_value', Valid::inPOST('sale_value'))
                        ->set('date_start', $this->start_date)
                        ->set('date_end', $this->end_date)
                        ->set('default_set', $this->default)
                        ->save();
            }

            Messages::alert('add_discount_sale', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit(): void {
        if (Valid::inPOST('edit')) {

            $MODULE_DB = Modules::moduleDatabase();

            if ($this->default != 0) {

                Db::connect()
                        ->update($MODULE_DB)
                        ->set('default_set', 0)
                        ->save();
            }

            for ($x = 0; $x < Lang::$count; $x++) {

                Db::connect()
                        ->update($MODULE_DB)
                        ->set('name', Valid::inPOST('name_module_' . $x))
                        ->set('sale_value', Valid::inPOST('sale_value'))
                        ->set('date_start', $this->start_date)
                        ->set('date_end', $this->end_date)
                        ->set('default_set', $this->default)
                        ->where('id=', Valid::inPOST('edit'))
                        ->and('language=', lang('#lang_all')[$x])
                        ->save();
            }

            Messages::alert('edit_discount_sale', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {

            $MODULE_DB = Modules::moduleDatabase();

            $discount_id_array = Db::connect()
                    ->read(TABLE_PRODUCTS)
                    ->selectAssoc('id')
                    ->where('language=', lang('#lang_all')[0])
                    ->save();

            foreach ($discount_id_array as $discount_id_arr) {

                $discount_str_temp = Db::connect()
                        ->read(TABLE_PRODUCTS)
                        ->selectValue('discount')
                        ->where('id=', $discount_id_arr['id'])
                        ->save();

                $discount_str_explode_temp = json_decode($discount_str_temp, true);
                $discount_str_explode = Func::removeValueFromArrayLevel('sale', Valid::inPOST('delete'), $discount_str_explode_temp);

                Db::connect()
                        ->update(TABLE_PRODUCTS)
                        ->set('discount', json_encode($discount_str_explode))
                        ->where('id=', $discount_id_arr['id'])
                        ->save();
            }

            Db::connect()
                    ->delete($MODULE_DB)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete_discount_sale', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $MODULE_DB = Modules::moduleDatabase();

        self::$sql_data = Db::connect()
                ->read($MODULE_DB)
                ->selectAssoc('*')
                ->orderByDesc('id')
                ->save();

        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::data($lines);

        self::$this_time = SystemClock::nowUnixTime();
    }

    /**
     * Modal
     *
     */
    public function modal(): void {
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
                        $sale_value[$modal_id] = (float) $sql_modal['sale_value'];
                        $date_start[$modal_id] = $sql_modal['date_start'];
                        $date_end[$modal_id] = $sql_modal['date_end'];
                        $default_set[$modal_id] = (int) $sql_modal['default_set'];
                    }
                }

                ksort($name);

                self::$json_data = json_encode([
                    'name' => $name,
                    'value' => $sale_value,
                    'start' => $date_start,
                    'end' => $date_end,
                    'default' => $default_set
                ]);
            }
        }
    }

}
