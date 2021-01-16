<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для модулей оплаты / Class for payment modules
 *
 * @package Payment
 * @author eMarket
 * 
 */
final class Payment {

    /**
     * Список модулей оплаты, которые доступны для выбранного модуля доставки / List of payment modules that are available for the selected delivery module
     * @param string $name (название модуля доставки / payment module name)
     * @return array $output (выходные данные / output data)
     */
    public static function paymentModulesAvailable($name) {
        $data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE active=? AND type=?", [1, 'payment']);

        $output = [];
        foreach ($data as $payment_module) {
            $shipping_val = json_decode(\eMarket\Core\Pdo::getCellFalse("SELECT shipping_module FROM " . DB_PREFIX . 'modules_payment_' . $payment_module['name'], []), 1);
            if (is_array($shipping_val) && in_array($name, $shipping_val) && !in_array($payment_module['name'], $output)) {
                array_push($output, $payment_module['name']);
            }
        }
        return $output;
    }

    /**
     * Загрузка данных с модулей оплаты / Loading data from payment modules
     * 
     * @param array $input (данные по доступным именам модулей доставки / data on available names of delivery modules)
     * @return array $modules_data (выходные данные / output data)
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

?>