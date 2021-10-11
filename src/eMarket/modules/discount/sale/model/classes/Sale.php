<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules\Discount;

use eMarket\Core\{
    Eac,
    Ecb,
    Func,
    Interfaces,
    Lang,
    Messages,
    Modules,
    Pages,
    Pdo,
    Valid
};
use eMarket\Admin\HeaderMenu;

/**
 * Module Sale
 *
 * @package Discount modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Sale {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $this_time = FALSE;

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
        HeaderMenu::$menu[HeaderMenu::$menu_marketing][] = ['?route=settings/modules/edit&type=discount&name=sale&alias=true', 'bi-star', lang('modules_discount_sale_name'), '', 'false'];
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
        $products_data = Pdo::getAssoc("SELECT id, discount FROM " . TABLE_PRODUCTS . " WHERE language=?", [lang('#lang_all')[0]]);
        foreach ($products_data as $data) {
            $discounts = json_decode($data['discount'], true);
            unset($discounts['sale']);
            Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discounts), $data['id']]);
        }
    }

    /**
     * Status
     *
     * @return mixed
     */
    public static function status(): mixed {
        $module_active = Pdo::getValue("SELECT active FROM " . TABLE_MODULES . " WHERE name=? AND type=?", ['sale', 'discount']);
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

        $INTERFACE = new Interfaces();

        if (array_key_exists('sale', $discount_val) && count($discount_val['sale']) > 0 && self::status() != FALSE && self::status() == 1) {

            $discount_out = [];
            $discount_names = [];

            foreach ($discount_val['sale'] as $val) {
                $data = Pdo::getAssoc("SELECT sale_value, name, UNIX_TIMESTAMP (date_start), UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=? AND id=?", [$language, $val])[0];
                if (count($data) > 0) {
                    $this_time = time();
                    $date_start = $data['UNIX_TIMESTAMP (date_start)'];
                    $date_end = $data['UNIX_TIMESTAMP (date_end)'];

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

            $INTERFACE->save('discount', 'sale', $out_data);
        } else {

            $out_data = [
                'price' => $input_price,
                'names' => 'false',
                'discounts' => 'false'
            ];

            $INTERFACE->save('discount', 'sale', $out_data);
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
                            $products_id = Pdo::getAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = Pdo::getValue("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, true);

                                if (!array_key_exists('sale', $discount_array)) {
                                    $discount_array['sale'] = [$discount];
                                } else {
                                    if (!in_array($discount, $discount_array['sale'])) {
                                        array_push($discount_array['sale'], $discount);
                                    }
                                }

                                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $val['id']]);
                                Messages::alert('sale_on', 'success', lang('action_completed_successfully'), 0, true);
                            }

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }
                        }
                        if (Valid::inPostJson('idsx_sale_off_key') == 'Off') {
                            $products_id = Pdo::getAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = Pdo::getValue("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, true);

                                if (array_key_exists('sale', $discount_array)) {
                                    foreach ($discount_array['sale'] as $key_del => $name_del) {
                                        if ($name_del == $discount) {
                                            unset($discount_array['sale'][$key_del]);
                                        }
                                    }
                                }

                                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $val['id']]);
                            }

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }
                            Messages::alert('sale_off', 'success', lang('action_completed_successfully'), 0, true);
                        }
                        if (Valid::inPostJson('idsx_sale_off_all_key') == 'OffAll') {
                            $products_id = Pdo::getAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = Pdo::getValue("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, true);

                                if (array_key_exists('sale', $discount_array)) {
                                    unset($discount_array['sale']);
                                }

                                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $val['id']]);
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
                        $discount_json = Pdo::getValue("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, true);

                        if (!array_key_exists('sale', $discount_array)) {
                            $discount_array['sale'] = [$discount];
                        } else {
                            if (!in_array($discount, $discount_array['sale'])) {
                                array_push($discount_array['sale'], $discount);
                            }
                        }

                        Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
                        Messages::alert('sale_on', 'success', lang('action_completed_successfully'), 0, true);
                    }
                    if (Valid::inPostJson('idsx_sale_off_key') == 'Off') {
                        $id_prod = explode('products_', $idx[$i]);
                        $discount_json = Pdo::getValue("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, true);

                        if (array_key_exists('sale', $discount_array)) {
                            foreach ($discount_array['sale'] as $key_del => $name_del) {
                                if ($name_del == $discount) {
                                    unset($discount_array['sale'][$key_del]);
                                }
                            }
                        }

                        Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
                        Messages::alert('sale_off', 'success', lang('action_completed_successfully'), 0, true);
                    }
                    if (Valid::inPostJson('idsx_sale_off_all_key') == 'OffAll') {
                        $id_prod = explode('products_', $idx[$i]);
                        $discount_json = Pdo::getValue("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, true);

                        if (array_key_exists('sale', $discount_array)) {
                            unset($discount_array['sale']);
                        }
                        Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
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

            if (Valid::inPOST('start_date')) {
                $start_date = date('Y-m-d', strtotime(Valid::inPOST('start_date')));
            } else {
                $start_date = NULL;
            }

            if (Valid::inPOST('end_date')) {
                $end_date = date('Y-m-d', strtotime(Valid::inPOST('end_date')));
            } else {
                $end_date = NULL;
            }

            if (Valid::inPOST('default_module')) {
                $default_value = 1;
            } else {
                $default_value = 0;
            }

            $id_max = Pdo::getValue("SELECT id FROM " . $MODULE_DB . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_value != 0) {
                Pdo::action("UPDATE " . $MODULE_DB . " SET default_set=?", [0]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("INSERT INTO " . $MODULE_DB . " SET id=?, name=?, language=?, sale_value=?, date_start=?, date_end=?, default_set=?", [$id, Valid::inPOST('name_module_' . $x), lang('#lang_all')[$x], Valid::inPOST('sale_value'), $start_date, $end_date, $default_value]);
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

            if (Valid::inPOST('start_date')) {
                $start_date = date('Y-m-d', strtotime(Valid::inPOST('start_date')));
            } else {
                $start_date = NULL;
            }
            if (Valid::inPOST('end_date')) {
                $end_date = date('Y-m-d', strtotime(Valid::inPOST('end_date')));
            } else {
                $end_date = NULL;
            }

            if (Valid::inPOST('default_module')) {
                $default_value = 1;
            } else {
                $default_value = 0;
            }

            if ($default_value != 0) {
                Pdo::action("UPDATE " . $MODULE_DB . " SET default_set=?", [0]);
            }

            for ($x = 0; $x < Lang::$count; $x++) {
                Pdo::action("UPDATE " . $MODULE_DB . " SET name=?, sale_value=?, date_start=?, date_end=?, default_set=? WHERE id=? AND language=?", [Valid::inPOST('name_module_' . $x), Valid::inPOST('sale_value'), $start_date, $end_date, $default_value, Valid::inPOST('edit'), lang('#lang_all')[$x]]);
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

            $discount_id_array = Pdo::getAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=?", [lang('#lang_all')[0]]);

            foreach ($discount_id_array as $discount_id_arr) {
                $discount_str_temp = Pdo::getValue("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$discount_id_arr]);
                $discount_str_explode_temp = explode(',', $discount_str_temp);
                $discount_str_explode = Func::deleteValInArray(Func::deleteEmptyInArray($discount_str_explode_temp), [Valid::inPOST('delete')]);
                $discount_str_implode = implode(',', $discount_str_explode);
                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [$discount_str_implode, $discount_id_arr]);
            }

            Pdo::action("DELETE FROM " . $MODULE_DB . " WHERE id=?", [Valid::inPOST('delete')]);
            Messages::alert('delete_discount_sale', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $MODULE_DB = Modules::moduleDatabase();

        self::$sql_data = Pdo::getAssoc("SELECT *, UNIX_TIMESTAMP (date_end) FROM " . $MODULE_DB . " ORDER BY id DESC", []);
        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::data($lines);

        self::$this_time = time();
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
                        $default_set[$modal_id] = $sql_modal['default_set'];
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
