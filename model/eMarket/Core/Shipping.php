<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для модулей доставки / Class for shipping modules
 *
 * @package Shipping
 * @author eMarket
 * 
 */
final class Shipping {

    /**
     * Список зон, для которых доступна доставка покупателю / List of zones for which delivery to the buyer is available
     * @param array $region (номера регинов / regions numbers)
     * @return array $output (выходные данные / output data)
     */
    public static function shippingZonesAvailable($region) {
        $data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE active=? AND type=?", [1, 'shipping']);

        $modules_data = [];
        foreach ($data as $module) {
            $mod_array = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_' . $module['name'], []);
            array_push($modules_data, $mod_array);
        }

        $output = [];
        $zones_id = \eMarket\Core\Pdo::getCellFalse("SELECT zones_id FROM " . TABLE_ZONES_VALUE . " WHERE regions_id=?", [$region]);

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
     * Список модулей доставки, для которых доступна доставка покупателю / List of shipping modules for which delivery to the buyer is available
     * @param array $shipping_zones_id_available (id зон, в которых находится регион / id of zones in which the region is located)
     * @return array $output (выходные данные / output data)
     */
    public static function shippingModulesAvailable($shipping_zones_id_available) {
        $data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE active=? AND type=?", [1, 'shipping']);

        $modules_data = [];
        foreach ($data as $module) {
            $mod_array = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_' . $module['name'], []);
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
     * Загрузка данных с модулей доставки / Loading data from shipping modules
     * 
     * @param array $zones_id (данные по доступным зонам доставки для региона / data on available shipping zones for region)
     * @return array $modules_data (output data)
     */
    public static function loadData($zones_id) {
        
        $modules_names = self::shippingModulesAvailable($zones_id); // данные в виде названия модулей

        $modules_data = [];
        foreach ($modules_names as $name) {
            $namespace = '\eMarket\Core\Modules\Shipping\\' . ucfirst($name);
            $load = $namespace::load($zones_id);
            if ($load != FALSE) {
                array_push($modules_data, $load);
            }
        }
        return $modules_data;
    }

    /**
     * Фильтрация и сортировка данных / Filtering and sorting data
     * 
     * @param array $interface_data_all (input data)
     * @return array|FALSE $interface (output data)
     */
    public static function filterData($interface_data_all) {

        if (count($interface_data_all) > 0) {
            $chanel_minimum_price = array_column($interface_data_all, 'chanel_minimum_price');
            array_multisort($chanel_minimum_price, SORT_ASC, $interface_data_all);

            $interface_minimum_price = [];
            foreach ($interface_data_all as $val) {
                if ($val['chanel_minimum_price'] == $interface_data_all[0]['chanel_minimum_price']) {
                    array_push($interface_minimum_price, $val);
                }
            }

            $chanel_minimum_shipping_price = array_column($interface_minimum_price, 'chanel_shipping_price');
            array_multisort($chanel_minimum_shipping_price, SORT_ASC, $interface_minimum_price);

            $interface = $interface_minimum_price[0];

            return $interface;
        } else {
            return FALSE;
        }
    }

}

?>