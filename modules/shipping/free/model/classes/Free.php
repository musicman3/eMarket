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

namespace eMarket\Modules\Shipping;

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

        \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_MODULES . " SET name=?, type=?, page=?, position=?, sort=?, install=?, active=?", [$module[1], $module[0], NULL, NULL, NULL, 1, 1]);
        //Загружаем БД из файла
        \eMarket\Pdo::dbInstall(ROOT . '/modules/' . $module[0] . '/' . $module[1] . '/install/');
    }

    /**
     * Удаление модуля
     *
     * @param array $module (входящие данные)
     */
    public static function uninstall($module) {
        // Удаляем
        \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_MODULES . " WHERE name=? AND type=?", [$module[1], $module[0]]);
        \eMarket\Pdo::inPrepare("DROP TABLE " . DB_PREFIX . 'modules_' . $module[0] . '_' . $module[1], []);
    }

    /**
     * Загрузка данных по модулю
     *
     * @param array $zones_id (данные по используемым зонам)
     * @return array|FALSE $output (выходные данные)
     */
    public static function load($zones_id) {

        $interface_data_all = [];

        foreach ($zones_id as $zone) {
            $data = \eMarket\Pdo::getColAssoc("SELECT minimum_price FROM " . DB_PREFIX . 'modules_shipping_free' . " WHERE shipping_zone=?", [$zone])[0];

            // Интерфейс для модулей доставки
            $interface_data = [
                'chanel_module' => 'free',
                'chanel_name' => lang('modules_shipping_free_name'),
                'chanel_total_price' => \eMarket\Ecb::totalPriceCartWithSale(),
                'chanel_total_price_format' => \eMarket\Products::productPrice(\eMarket\Ecb::totalPriceCartWithSale(), 1),
                'chanel_minimum_price' => $data['minimum_price'],
                'chanel_minimum_price_format' => \eMarket\Products::productPrice($data['minimum_price'], 1),
                'chanel_shipping_price' => 0,
                'chanel_shipping_price_format' => \eMarket\Products::productPrice(0, 1),
                'chanel_total_price_with_shipping' => \eMarket\Ecb::totalPriceCartWithSale() + 0,
                'chanel_total_price_with_shipping_format' => \eMarket\Products::productPrice(\eMarket\Ecb::totalPriceCartWithSale() + 0, 1),
                'chanel_tax' => '',
                'chanel_image' => ''
            ];
            array_push($interface_data_all, $interface_data);
        }
        return \eMarket\Shipping::filterData($interface_data_all);
    }

}

?>
