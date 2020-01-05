<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket;

/**
 * Класс для обработки модулей доставки
 *
 * @package Shipping
 * @author eMarket
 * 
 */
final class Shipping {

    /**
     * Список зон, для которых доступна доставка покупателю
     * @param array $region (номера регинов)
     * @return array $output (выходные данные в виде id зон, в которых находится регион)
     */
    public static function shippingZonesAvailable($region) {
        $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE install=? AND active=? AND type=?", [1, 1, 'shipping']);

        $modules_data = [];
        foreach ($data as $module) {
            $mod_array = \eMarket\Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_' . $module['name'], []);
            array_push($modules_data, $mod_array);
        }

        $output = [];
        $zones_id = \eMarket\Pdo::getCellFalse("SELECT zones_id FROM " . TABLE_ZONES_VALUE . " WHERE regions_id=?", [$region]);

        if ($zones_id != FALSE) {
            foreach ($modules_data as $mod_data_ext) {
                foreach ($mod_data_ext as $mod_data) {
                    if ($mod_data['shipping_zone'] == $zones_id) {
                        array_push($output, $zones_id);
                    }
                }
            }
        }

        return $output;
    }

    /**
     * Список модулей доставки, для которых доступна доставка покупателю
     * @param array $shipping_zones_id_available (id зон, в которых находится регион)
     * @return array $output (выходные данные в виде названия модулей)
     */
    public static function shippingModulesAvailable($shipping_zones_id_available) {
        $data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE install=? AND active=? AND type=?", [1, 1, 'shipping']);

        $modules_data = [];
        foreach ($data as $module) {
            $mod_array = \eMarket\Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_' . $module['name'], []);
            array_push($modules_data, [$module['name'] => $mod_array]);
        }
        $output = [];

        foreach ($data as $val) {
            foreach ($modules_data as $data_arr) {
                if (isset($data_arr[$val['name']])) {
                    foreach ($data_arr[$val['name']] as $data_name) {
                        if (in_array($data_name['shipping_zone'], $shipping_zones_id_available)) {
                            if (!in_array($val['name'], $output)) {
                                array_push($output, $val['name']);
                            }
                        }
                    }
                }
            }
        }

        return $output;
    }

    /**
     * Загрузка данных с модулей доставки
     * 
     * @param array $zones_id (данные по доступным зонам доставки для региона)
     * @param array $modules_names (данные по доступным именам модулей доставки для региона)
     * @return array $output (выходные данные)
     */
    public static function loadData($zones_id, $modules_names) {

        $modules_data = [];
        foreach ($modules_names as $name) {
            $namespace = '\eMarket\Modules\Shipping\\' . ucfirst($name);
            $load = $namespace::load($zones_id);
            if ($load != FALSE) {
                array_push($modules_data, $load);
            }
        }
        return $modules_data;
    }

}

?>