<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules\Shipping;

use eMarket\Core\{
    Ecb,
    DataBuffer,
    Interfaces\ShippingModulesInterface,
    Messages,
    Modules,
    Pages,
    Settings,
    Shipping,
    Valid
};
use Cruder\Db;

/**
 * Module Shipping Free
 *
 * @package Shipping modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Free implements ShippingModulesInterface {

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
    }

    /**
     * Load data
     *
     * @param array $zones_id (Zones id)
     * @return array|FALSE (Data)
     */
    public static function load(array $zones_id): void {

        $interface_data_all = [];
        $DataBuffer = new DataBuffer();
        Ecb::priceTerminal();

        foreach ($zones_id as $zone) {

            $data_arr = Db::connect()
                    ->read(DB_PREFIX . 'modules_shipping_free')
                    ->selectAssoc('*')
                    ->where('shipping_zone=', $zone)
                    ->save();

            foreach ($data_arr as $data) {

                $interface_data = [
                    'chanel_id' => $data['id'],
                    'chanel_module_name' => 'free',
                    'chanel_name' => lang('modules_shipping_free_name'),
                    'chanel_total_price' => $DataBuffer->load('priceTerminal', 'data', 'discounted_price'),
                    'chanel_total_price_format' => Ecb::formatPrice($DataBuffer->load('priceTerminal', 'data', 'discounted_price'), 1),
                    'chanel_minimum_price' => Ecb::currencyPrice($data['minimum_price'], $data['currency']),
                    'chanel_minimum_price_format' => Ecb::formatPrice(Ecb::currencyPrice($data['minimum_price'], $data['currency']), 1),
                    'chanel_shipping_price' => 0,
                    'chanel_shipping_price_format' => Ecb::formatPrice(0, 1),
                    'chanel_total_price_with_shipping' => $DataBuffer->load('priceTerminal', 'data', 'discounted_price') + 0,
                    'chanel_total_price_with_shipping_format' => Ecb::formatPrice($DataBuffer->load('priceTerminal', 'data', 'discounted_price') + 0, 1),
                    'chanel_total_tax' => $DataBuffer->load('priceTerminal', 'data', 'total_tax_price'),
                    'chanel_total_tax_format' => Ecb::formatPrice($DataBuffer->load('priceTerminal', 'data', 'total_tax_price'), 1),
                    'chanel_image' => ''
                ];
                array_push($interface_data_all, $interface_data);
            }
        }
        $interface = Shipping::filterData($interface_data_all);

        $DataBuffer->save('shipping', 'free', $interface);
    }

    /**
     * Add
     *
     */
    public function add(): void {
        if (Valid::inPOST('add')) {
            $MODULE_DB = Modules::moduleDatabase();

            Db::connect()
                    ->create($MODULE_DB)
                    ->set('minimum_price', Valid::inPOST('minimum_price'))
                    ->set('shipping_zone', Valid::inPOST('zone'))
                    ->set('currency', Settings::currencyDefault()[0])
                    ->save();

            Messages::alert('add_shipping_free', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Edit
     *
     */
    public function edit(): void {
        if (Valid::inPOST('edit')) {
            $MODULE_DB = Modules::moduleDatabase();

            Db::connect()
                    ->update($MODULE_DB)
                    ->set('minimum_price', Valid::inPOST('minimum_price'))
                    ->set('shipping_zone', Valid::inPOST('zone'))
                    ->set('currency', Settings::currencyDefault()[0])
                    ->where('id=', Valid::inPOST('edit'))
                    ->save();

            Messages::alert('edit_shipping_free', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {
            $MODULE_DB = Modules::moduleDatabase();

            Db::connect()
                    ->delete($MODULE_DB)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            Messages::alert('delete_shipping_free', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $MODULE_DB = Modules::moduleDatabase();

        self::$zones = Db::connect()
                ->read(TABLE_ZONES)
                ->selectAssoc('*')
                ->where('language=', lang('#lang_all')[0])
                ->save();

        self::$zones_name = [];
        foreach (self::$zones as $val) {
            self::$zones_name[$val['id']] = $val['name'];
        }

        self::$sql_data = Db::connect()
                ->read($MODULE_DB)
                ->selectAssoc('*')
                ->orderByDesc('id')
                ->save();

        Pages::data(self::$sql_data);
    }

    /**
     * Modal
     *
     */
    public function modal(): void {
        self::$json_data = json_encode([]);
        $MODULE_DB = Modules::moduleDatabase();
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                $query = Db::connect()
                                ->read($MODULE_DB)
                                ->selectAssoc('minimum_price, shipping_zone, currency')
                                ->where('id=', $modal_id)
                                ->save()[0];

                $minimum_price[$modal_id] = round(Ecb::currencyPrice($query['minimum_price'], $query['currency']), 2);
                $shipping_zone[$modal_id] = $query['shipping_zone'];

                self::$json_data = json_encode([
                    'price' => $minimum_price,
                    'zone' => $shipping_zone
                ]);
            }
        }
    }

}
