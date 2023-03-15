<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules\Payment;

use eMarket\Core\{
    Interfaces,
    Messages,
    Modules,
    Pdo,
    Routing,
    Settings,
    Valid
};

/**
 * Module Cash
 *
 * @package Payment modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Cash {

    public static $shipping_method;
    public static $order_status;
    public static $order_status_selected;
    public static $shipping_val;

    /**
     * Constructor
     *
     */
    function __construct() {
        Routing::jsModulesHandler();
        if (Settings::path() == 'admin') {
            $this->save();
            $this->data();
        }
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
     * @return array $interface (data)
     */
    public static function load(): void {

        $INTERFACE = new Interfaces();

        $interface = [
            'chanel_module_name' => 'cash',
            'chanel_name' => lang('modules_payment_cash_name'),
            'chanel_payment_price' => 0,
            'chanel_payment_currency' => '',
            'chanel_callback_url' => '', // example: https://w3s.webmoney.ru/asp/XMLInvoice.asp
            'chanel_callback_type' => 'get', // post/get
            'chanel_callback_data' => json_encode(['route' => 'success']), // example: ['route' => 'success', 'id' => '', 'price' => '']
            'chanel_image' => ''
        ];

        $INTERFACE->save('payment', 'cash', $interface);
    }

    /**
     * Save
     *
     */
    public function save(): void {
        if (Valid::inPOST('save')) {

            $MODULE_DB = Modules::moduleDatabase();

            $data = Pdo::getValue("SELECT * FROM " . $MODULE_DB, []);
            if ($data == FALSE) {
                if (Valid::inPOST('multiselect')) {
                    $multiselect = json_encode(Valid::inPOST('multiselect'));
                    Pdo::action("INSERT INTO " . $MODULE_DB . " SET order_status=?, shipping_module=?", [Valid::inPOST('order_status'), $multiselect]);
                }
            } elseif (Valid::inPOST('multiselect')) {
                $multiselect = json_encode(Valid::inPOST('multiselect'));
                Pdo::action("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [Valid::inPOST('order_status'), $multiselect]);
            } else {
                Pdo::action("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [Valid::inPOST('order_status'), NULL]);
            }

            Messages::alert('save_payment_cash', 'success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        $MODULE_DB = Modules::moduleDatabase();

        self::$shipping_method = Pdo::getAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=? ORDER BY name ASC", ['shipping', 1]);
        self::$order_status = Pdo::getAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
        self::$order_status_selected = Pdo::getValue("SELECT order_status FROM " . $MODULE_DB, []);
        self::$shipping_val = json_decode((string) Pdo::getValue("SELECT shipping_module FROM " . $MODULE_DB, []), true);
    }

}
