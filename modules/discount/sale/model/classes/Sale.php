<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core\Modules\Discount;

use \eMarket\Core\{
    Eac,
    Ecb,
    Func,
    Interfaces,
    Lang,
    Messages,
    Modules,
    Pages,
    Pdo,
    Settings,
    Valid
};

/**
 * Module Sale
 *
 * @package Sale
 * @author eMarket
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
     * Install
     *
     * @param array $module (input data)
     */
    public static function install($module) {
        Modules::install($module);
    }

    /**
     * Delete
     *
     * @param array $module (input data)
     */
    public static function uninstall($module) {
        Modules::uninstall($module);
        $products_data = Pdo::getColAssoc("SELECT id, discount FROM " . TABLE_PRODUCTS . " WHERE language=?", [lang('#lang_all')[0]]);
        foreach ($products_data as $data) {
            $discounts = json_decode($data['discount'], 1);
            unset($discounts['sale']);
            Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discounts), $data['id']]);
        }
    }

    /**
     * Status
     *
     * @return string|FALSE
     */
    public static function status() {
        $module_active = Pdo::getCellFalse("SELECT active FROM " . TABLE_MODULES . " WHERE name=? AND type=?", ['sale', 'discount']);
        return $module_active;
    }

    /**
     * Output data for calculation block
     *
     * @param array $input (input data)
     * @param string $language (language)
     * @return array (output data)
     */
    public static function dataInterface($input, $language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }

        $discount_val = json_decode($input['discount'], 1);
        $currency = $input['currency'];
        $input_price = Ecb::currencyPrice($input['price'], $currency);

        $INTERFACE = new Interfaces();

        if (array_key_exists('sale', $discount_val) && count($discount_val['sale']) > 0 && self::status() != FALSE && self::status() == 1) {

            $discount_out = [];
            $discount_names = [];

            foreach ($discount_val['sale'] as $val) {
                $data = Pdo::getColAssoc("SELECT sale_value, name, UNIX_TIMESTAMP (date_start), UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=? AND id=?", [$language, $val])[0];
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
    public static function initEac() {

        if ((Valid::inPOST('idsx_sale_on_key') == 'On')
                or (Valid::inPOST('idsx_sale_off_key') == 'Off')
                or (Valid::inPOST('idsx_sale_off_all_key') == 'OffAll')) {

            $parent_id_real = (int) Valid::inPOST('idsx_real_parent_id');

            if (Valid::inPOST('idsx_sale_on_key') == 'On') {
                $idx = Func::deleteEmptyInArray(Valid::inPOST('idsx_sale_on_id'));
                $discount = Valid::inPOST('sale');
            }

            if (Valid::inPOST('idsx_sale_off_key') == 'Off') {
                $idx = Func::deleteEmptyInArray(Valid::inPOST('idsx_sale_off_id'));
                $discount = Valid::inPOST('sale');
            }

            if (Valid::inPOST('idsx_sale_off_all_key') == 'OffAll') {
                $idx = Func::deleteEmptyInArray(Valid::inPOST('idsx_sale_off_all_id'));
                $discount = Valid::inPOST('sale');
            }

            if (is_array($idx) == FALSE) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    Eac::$parent_id = Eac::dataParentId($idx[$i]);
                    $keys = Eac::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if (Valid::inPOST('idsx_sale_on_key') == 'On') {
                            $products_id = Pdo::getColAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, 1);

                                if (!array_key_exists('sale', $discount_array)) {
                                    $discount_array['sale'] = [$discount];
                                } else {
                                    if (!in_array($discount, $discount_array['sale'])) {
                                        array_push($discount_array['sale'], $discount);
                                    }
                                }

                                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $val['id']]);
                            }

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }
                        }
                        if (Valid::inPOST('idsx_sale_off_key') == 'Off') {
                            $products_id = Pdo::getColAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, 1);

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
                        }
                        if (Valid::inPOST('idsx_sale_off_all_key') == 'OffAll') {
                            $products_id = Pdo::getColAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, 1);

                                if (array_key_exists('sale', $discount_array)) {
                                    unset($discount_array['sale']);
                                }

                                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $val['id']]);
                            }

                            if ($parent_id_real > 0) {
                                Eac::$parent_id = $parent_id_real;
                            }
                        }
                    }
                } else {
                    if (Valid::inPOST('idsx_sale_on_key') == 'On') {
                        $id_prod = explode('product_', $idx[$i]);
                        $discount_json = Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, 1);

                        if (!array_key_exists('sale', $discount_array)) {
                            $discount_array['sale'] = [$discount];
                        } else {
                            if (!in_array($discount, $discount_array['sale'])) {
                                array_push($discount_array['sale'], $discount);
                            }
                        }

                        Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
                    }
                    if (Valid::inPOST('idsx_sale_off_key') == 'Off') {
                        $id_prod = explode('product_', $idx[$i]);
                        $discount_json = Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, 1);

                        if (array_key_exists('sale', $discount_array)) {
                            foreach ($discount_array['sale'] as $key_del => $name_del) {
                                if ($name_del == $discount) {
                                    unset($discount_array['sale'][$key_del]);
                                }
                            }
                        }

                        Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
                    }
                    if (Valid::inPOST('idsx_sale_off_all_key') == 'OffAll') {
                        $id_prod = explode('product_', $idx[$i]);
                        $discount_json = Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, 1);

                        if (array_key_exists('sale', $discount_array)) {
                            unset($discount_array['sale']);
                        }
                        Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
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
    public function add() {
        if (Valid::inPOST('add')) {

            $MODULE_DB = Settings::moduleDatabase();

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

            $id_max = Pdo::selectPrepare("SELECT id FROM " . $MODULE_DB . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
            $id = intval($id_max) + 1;

            if ($id > 1 && $default_value != 0) {
                Pdo::action("UPDATE " . $MODULE_DB . " SET default_set=?", [0]);
            }

            for ($x = 0; $x < Lang::$COUNT; $x++) {
                Pdo::action("INSERT INTO " . $MODULE_DB . " SET id=?, name=?, language=?, sale_value=?, date_start=?, date_end=?, default_set=?", [$id, Valid::inPOST('name_module_' . $x), lang('#lang_all')[$x], Valid::inPOST('sale_value'), $start_date, $end_date, $default_value]);
            }

            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (Valid::inPOST('edit')) {

            $MODULE_DB = Settings::moduleDatabase();

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

            for ($x = 0; $x < Lang::$COUNT; $x++) {
                Pdo::action("UPDATE " . $MODULE_DB . " SET name=?, sale_value=?, date_start=?, date_end=?, default_set=? WHERE id=? AND language=?", [Valid::inPOST('name_module_' . $x), Valid::inPOST('sale_value'), $start_date, $end_date, $default_value, Valid::inPOST('edit'), lang('#lang_all')[$x]]);
            }

            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (Valid::inPOST('delete')) {

            $MODULE_DB = Settings::moduleDatabase();

            $discount_id_array = Pdo::getCol("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=?", [lang('#lang_all')[0]]);

            foreach ($discount_id_array as $discount_id_arr) {
                $discount_str_temp = Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$discount_id_arr]);
                $discount_str_explode_temp = explode(',', $discount_str_temp);
                $discount_str_explode = Func::deleteValInArray(Func::deleteEmptyInArray($discount_str_explode_temp), [Valid::inPOST('delete')]);
                $discount_str_implode = implode(',', $discount_str_explode);
                Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [$discount_str_implode, $discount_id_arr]);
            }

            Pdo::action("DELETE FROM " . $MODULE_DB . " WHERE id=?", [Valid::inPOST('delete')]);
            Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        $MODULE_DB = Settings::moduleDatabase();

        self::$sql_data = Pdo::getColAssoc("SELECT *, UNIX_TIMESTAMP (date_end) FROM " . $MODULE_DB . " ORDER BY id DESC", []);
        $lines = Func::filterData(self::$sql_data, 'language', lang('#lang_all')[0]);
        Pages::table($lines);

        self::$this_time = time();
    }

    /**
     * Modal
     *
     */
    public function modal() {
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
