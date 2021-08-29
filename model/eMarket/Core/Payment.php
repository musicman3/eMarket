<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Pdo,
};

/**
 * Payment
 *
 * @package Payment
 * @author eMarket
 * 
 */
final class Payment {

    /**
     * List of payment modules that are available for the selected delivery module
     * @param string $name Payment module name
     * @return array
     */
    public static function paymentModulesAvailable($name) {
        $data = Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE active=? AND type=?", [1, 'payment']);

        $output = [];
        foreach ($data as $payment_module) {
            $shipping_val = json_decode(Pdo::getCell("SELECT shipping_module FROM " . DB_PREFIX . 'modules_payment_' . $payment_module['name'], []), 1);
            if (is_array($shipping_val) && in_array($name, $shipping_val) && !in_array($payment_module['name'], $output)) {
                array_push($output, $payment_module['name']);
            }
        }
        return $output;
    }

    /**
     * Loading data from payment modules
     * 
     * @param array $input Data on available names of delivery modules
     * @return array
     */
    public static function loadData($input) {

        $modules_names = self::paymentModulesAvailable($input);

        $modules_data = [];
        foreach ($modules_names as $name) {
            $namespace = '\eMarket\Core\Modules\Payment\\' . ucfirst($name);
            $load = $namespace::load();
            array_push($modules_data, $load);
        }
        return $modules_data;
    }

}
