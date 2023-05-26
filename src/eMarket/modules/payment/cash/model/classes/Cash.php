<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core\Modules\Payment;

use eMarket\Core\{
    DataBuffer,
    Interfaces\PaymentModulesInterface,
    Messages,
    Modules,
    Routing,
    Settings,
    Valid
};
use Cruder\Db;

/**
 * Module Cash
 *
 * @package Payment modules
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Cash implements PaymentModulesInterface {

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

        $DataBuffer = new DataBuffer();

        $interface = [
            'chanel_module_name' => 'cash',
            'chanel_name' => lang('modules_payment_cash_name'),
            'chanel_payment_price' => 0,
            'chanel_payment_currency' => '',
            'chanel_callback_url' => HTTP_SERVER, // example: https://w3s.webmoney.ru/asp/XMLInvoice.asp
            'chanel_callback_type' => 'get', // post/get
            'chanel_callback_data' => json_encode(['route' => 'success']), // example: ['route' => 'success', 'id' => '', 'price' => '']
            'chanel_image' => ''
        ];

        $DataBuffer->save('payment', 'cash', $interface);
    }

    /**
     * Save
     *
     */
    public function save(): void {
        if (Valid::inPOST('save')) {

            $MODULE_DB = Modules::moduleDatabase();

            $data = Db::connect()
                    ->read($MODULE_DB)
                    ->selectValue('*')
                    ->save();

            if ($data == FALSE) {
                if (Valid::inPOST('multiselect')) {
                    $multiselect = json_encode(Valid::inPOST('multiselect'));

                    Db::connect()
                            ->create($MODULE_DB)
                            ->set('order_status', Valid::inPOST('order_status'))
                            ->set('shipping_module', $multiselect)
                            ->save();
                }
            } elseif (Valid::inPOST('multiselect')) {
                $multiselect = json_encode(Valid::inPOST('multiselect'));

                Db::connect()
                        ->update($MODULE_DB)
                        ->set('order_status', Valid::inPOST('order_status'))
                        ->set('shipping_module', $multiselect)
                        ->save();
            } else {

                Db::connect()
                        ->update($MODULE_DB)
                        ->set('order_status', Valid::inPOST('order_status'))
                        ->set('shipping_module', NULL)
                        ->save();
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

        self::$shipping_method = Db::connect()
                ->read(TABLE_MODULES)
                ->selectAssoc('*')
                ->where('type=', 'shipping')
                ->and('active=', 1)
                ->orderByAsc('name')
                ->save();

        self::$order_status = Db::connect()
                ->read(TABLE_ORDER_STATUS)
                ->selectAssoc('*')
                ->where('language=', lang('#lang_all')[0])
                ->orderByDesc('sort')
                ->save();

        self::$order_status_selected = Db::connect()
                ->read($MODULE_DB)
                ->selectValue('order_status')
                ->save();

        $shipping_val_prepare = Db::connect()
                ->read($MODULE_DB)
                ->selectValue('shipping_module')
                ->save();

        self::$shipping_val = json_decode((string) $shipping_val_prepare, true);
    }

}
