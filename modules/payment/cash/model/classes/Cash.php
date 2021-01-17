<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core\Modules\Payment;

/**
 * Module Cash
 *
 * @package Cash
 * @author eMarket
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
        $this->save();
        $this->data();
    }

    /**
     * Install
     *
     * @param array $module (input data)
     */
    public static function install($module) {
        // Инсталлируем
        \eMarket\Core\Modules::install($module);
    }

    /**
     * Delete
     *
     * @param array $module (input data)
     */
    public static function uninstall($module) {
        \eMarket\Core\Modules::uninstall($module);
    }

    /**
     * Load data
     *
     * @return array $interface (data)
     */
    public static function load() {

        $INTERFACE = new \eMarket\Core\Interfaces();

        $interface = [
            'chanel_module_name' => 'cash',
            'chanel_name' => lang('modules_payment_cash_name'),
            'chanel_payment_price' => 0,
            'chanel_payment_currency' => '',
            'chanel_callback_url' => '?route=success', // example: https://w3s.webmoney.ru/asp/XMLInvoice.asp
            'chanel_callback_type' => 'post', // post/get
            'chanel_callback_data' => json_encode([]), // example: ['id' => '', 'price' => '']
            'chanel_image' => ''
        ];

        $INTERFACE->save('payment', 'cash', $interface);
    }

    /**
     * Save
     *
     */
    public function save() {
        if (\eMarket\Core\Valid::inPOST('save')) {

            $MODULE_DB = \eMarket\Core\Settings::moduleDatabase();

            $data = \eMarket\Core\Pdo::getCellFalse("SELECT * FROM " . $MODULE_DB, []);
            if ($data == FALSE) {
                if (empty(\eMarket\Core\Valid::inPOST('multiselect')) == FALSE) {
                    $multiselect = json_encode(\eMarket\Core\Valid::inPOST('multiselect'));
                    \eMarket\Core\Pdo::action("INSERT INTO " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Core\Valid::inPOST('order_status'), $multiselect]);
                }
            } elseif (empty(\eMarket\Core\Valid::inPOST('multiselect')) == FALSE) {
                $multiselect = json_encode(\eMarket\Core\Valid::inPOST('multiselect'));
                \eMarket\Core\Pdo::action("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Core\Valid::inPOST('order_status'), $multiselect]);
            } else {
                \eMarket\Core\Pdo::action("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Core\Valid::inPOST('order_status'), NULL]);
            }

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
            exit;
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        $MODULE_DB = \eMarket\Core\Settings::moduleDatabase();

        self::$shipping_method = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=? ORDER BY name ASC", ['shipping', 1]);
        self::$order_status = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
        self::$order_status_selected = \eMarket\Core\Pdo::getCellFalse("SELECT order_status FROM " . $MODULE_DB, []);
        self::$shipping_val = json_decode(\eMarket\Core\Pdo::getCellFalse("SELECT shipping_module FROM " . $MODULE_DB, []), 1);
    }

}
