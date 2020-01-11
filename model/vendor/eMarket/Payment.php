<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для обработки модулей оплаты
 *
 * @package Payment
 * @author eMarket
 * 
 */
final class Payment {

    /**
     * Список модулей оплаты, которые доступны
     * @return array $output (выходные данные в виде названия модулей)
     */
    public static function paymentModulesAvailable() {
        $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE install=? AND active=? AND type=?", [1, 1, 'payment']);

        $output = [];
        foreach ($data as $module) {
            $shipping_val = \eMarket\Pdo::getCellFalse("SELECT shipping_module  FROM " . DB_PREFIX . 'modules_payment_' . $module['name'], []);
            if ($shipping_val != FALSE && $shipping_val != NULL) {
                array_push($output, $module['name']);
            }
        }

        return $output;
    }

    /**
     * Загрузка данных с модулей оплаты
     * 
     * @param array $modules_names (данные по доступным именам модулей доставки)
     * @return array $modules_data (выходные данные)
     */
    public static function loadData($modules_names) {

        $modules_data = [];
        foreach ($modules_names as $name) {
            $namespace = '\eMarket\Modules\Payment\\' . ucfirst($name);
            $load = $namespace::load();
            array_push($modules_data, $load);
        }
        return $modules_data;
    }

}

?>