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

        $counter = 0;
        foreach ($zones_id as $zone) {
            $data = \eMarket\Pdo::getColAssoc("SELECT minimum_price FROM " . DB_PREFIX . 'modules_shipping_free' . " WHERE shipping_zone=?", [$zone])[0];

            // Логика обработки
            if (\eMarket\Ecb::totalPriceCartWithSale() >= $data['minimum_price']) {
                
                // Интерфейс для модулей доставки
                $interface = [
                    'chanel_module' => 'free',
                    'chanel_name' => lang('modules_shipping_free_name'),
                    'chanel_minimum_price' => $data['minimum_price'],
                    'chanel_shipping_price' => '',
                    'chanel_tax' => '',
                    'chanel_image' => ''
                    ];
                $counter++;
            }
        }
        if ($counter > 0) {
            return $interface;
        } else {
            return FALSE;
        }
    }

}

?>
