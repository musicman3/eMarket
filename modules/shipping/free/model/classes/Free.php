<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core\Modules\Shipping;

use eMarket\Core\{
    Ecb,
    Interfaces,
    Messages,
    Modules,
    Pages,
    Pdo,
    Settings,
    Shipping,
    Valid
};

/**
 * Module Shipping Free
 *
 * @package Shipping
 * @author eMarket
 * 
 */
class Free {

    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $zones_name = FALSE;
    public static $zones = FALSE;

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
    }

    /**
     * Load data
     *
     * @param array $zones_id (Zones id)
     * @return array|FALSE (Data)
     */
    public static function load($zones_id) {

        $interface_data_all = [];
        $INTERFACE = new Interfaces();
        Ecb::priceTerminal();

        foreach ($zones_id as $zone) {
            $data_arr = Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_free' . " WHERE shipping_zone=?", [$zone]);
            foreach ($data_arr as $data) {

                $interface_data = [
                    'chanel_id' => $data['id'],
                    'chanel_module_name' => 'free',
                    'chanel_name' => lang('modules_shipping_free_name'),
                    'chanel_total_price' => $INTERFACE->load('priceTerminal', 'data', 'discounted_price'),
                    'chanel_total_price_format' => Ecb::formatPrice($INTERFACE->load('priceTerminal', 'data', 'discounted_price'), 1),
                    'chanel_minimum_price' => Ecb::currencyPrice($data['minimum_price'], $data['currency']),
                    'chanel_minimum_price_format' => Ecb::formatPrice(Ecb::currencyPrice($data['minimum_price'], $data['currency']), 1),
                    'chanel_shipping_price' => 0,
                    'chanel_shipping_price_format' => Ecb::formatPrice(0, 1),
                    'chanel_total_price_with_shipping' => $INTERFACE->load('priceTerminal', 'data', 'discounted_price') + 0,
                    'chanel_total_price_with_shipping_format' => Ecb::formatPrice($INTERFACE->load('priceTerminal', 'data', 'discounted_price') + 0, 1),
                    'chanel_total_tax' => $INTERFACE->load('priceTerminal', 'data', 'total_tax_price'),
                    'chanel_total_tax_format' => Ecb::formatPrice($INTERFACE->load('priceTerminal', 'data', 'total_tax_price'), 1),
                    'chanel_image' => ''
                ];
                array_push($interface_data_all, $interface_data);
            }
        }
        $interface = Shipping::filterData($interface_data_all);

        $INTERFACE->save('shipping', 'free', $interface);
    }

    /**
     * Add
     *
     */
    public function add() {
        if (Valid::inPOST('add')) {
            $MODULE_DB = Modules::moduleDatabase();
            Pdo::action("INSERT INTO " . $MODULE_DB . " SET minimum_price=?, shipping_zone=?, currency=?", [Valid::inPOST('minimum_price'), Valid::inPOST('zone'), Settings::currencyDefault()[0]]);

            Messages::alert('add', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (Valid::inPOST('edit')) {
            $MODULE_DB = Modules::moduleDatabase();
            Pdo::action("UPDATE " . $MODULE_DB . " SET minimum_price=?, shipping_zone=?, currency=? WHERE id=?", [Valid::inPOST('minimum_price'), Valid::inPOST('zone'), Settings::currencyDefault()[0], Valid::inPOST('edit')]);

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (Valid::inPOST('delete')) {
            $MODULE_DB = Modules::moduleDatabase();
            Pdo::action("DELETE FROM " . $MODULE_DB . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        $MODULE_DB = Modules::moduleDatabase();

        self::$zones = Pdo::getColAssoc("SELECT * FROM " . TABLE_ZONES . " WHERE language=?", [lang('#lang_all')[0]]);

        self::$zones_name = [];
        foreach (self::$zones as $val) {
            self::$zones_name[$val['id']] = $val['name'];
        }

        self::$sql_data = Pdo::getColAssoc("SELECT * FROM " . $MODULE_DB . " ORDER BY id DESC", []);
        Pages::data(self::$sql_data);
    }

    /**
     * Modal
     *
     */
    public function modal() {
        self::$json_data = json_encode([]);
        $MODULE_DB = Modules::moduleDatabase();
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                $query = Pdo::getRow("SELECT minimum_price, shipping_zone, currency FROM " . $MODULE_DB . " WHERE id=?", [$modal_id]);
                $minimum_price[$modal_id] = round(Ecb::currencyPrice($query[0], $query[2]), 2);
                $shipping_zone[$modal_id] = $query[1];

                self::$json_data = json_encode([
                    'price' => $minimum_price,
                    'zone' => $shipping_zone
                ]);
            }
        }
    }

}
