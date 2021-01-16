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

namespace eMarket\Core\Modules\Shipping;

/**
 * Класс модуля скидок
 *
 * @package Sale
 * @author eMarket
 * 
 */
class Free {

    /**
     * Инсталляция модуля
     *
     * @param array $module (входящие данные)
     */
    public static function install($module) {
        // Инсталлируем
        \eMarket\Core\Modules::install($module);
    }

    /**
     * Удаление модуля
     *
     * @param array $module (входящие данные)
     */
    public static function uninstall($module) {
        // Удаляем
        \eMarket\Core\Modules::uninstall($module);
    }

    /**
     * Загрузка данных по модулю
     *
     * @param array $zones_id (данные по используемым зонам)
     * @return array|FALSE $interface (выходные данные)
     */
    public static function load($zones_id) {

        $interface_data_all = [];
        $INTERFACE = new \eMarket\Core\Interfaces();
        \eMarket\Core\Ecb::priceTerminal();

        foreach ($zones_id as $zone) {
            $data_arr = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . DB_PREFIX . 'modules_shipping_free' . " WHERE shipping_zone=?", [$zone]);
            foreach ($data_arr as $data) {
                // Интерфейс для модулей доставки
                $interface_data = [
                    'chanel_id' => $data['id'],
                    'chanel_module_name' => 'free',
                    'chanel_name' => lang('modules_shipping_free_name'),
                    'chanel_total_price' => $INTERFACE->load('priceTerminal', 'data', 'discounted_price'),
                    'chanel_total_price_format' => \eMarket\Core\Ecb::formatPrice($INTERFACE->load('priceTerminal', 'data', 'discounted_price'), 1),
                    'chanel_minimum_price' => \eMarket\Core\Ecb::currencyPrice($data['minimum_price'], $data['currency']),
                    'chanel_minimum_price_format' => \eMarket\Core\Ecb::formatPrice(\eMarket\Core\Ecb::currencyPrice($data['minimum_price'], $data['currency']), 1),
                    'chanel_shipping_price' => 0,
                    'chanel_shipping_price_format' => \eMarket\Core\Ecb::formatPrice(0, 1),
                    'chanel_total_price_with_shipping' => $INTERFACE->load('priceTerminal', 'data', 'discounted_price') + 0,
                    'chanel_total_price_with_shipping_format' => \eMarket\Core\Ecb::formatPrice($INTERFACE->load('priceTerminal', 'data', 'discounted_price') + 0, 1),
                    'chanel_total_tax' => $INTERFACE->load('priceTerminal', 'data', 'total_tax_price'),
                    'chanel_total_tax_format' => \eMarket\Core\Ecb::formatPrice($INTERFACE->load('priceTerminal', 'data', 'total_tax_price'), 1),
                    'chanel_image' => ''
                ];
                array_push($interface_data_all, $interface_data);
            }
        }
        $interface = \eMarket\Core\Shipping::filterData($interface_data_all);
        
        $INTERFACE->save('shipping', 'free', $interface);
    }

}

?>
