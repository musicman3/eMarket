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

namespace eMarket\Modules\Payment;

/**
 * Класс модуля оплаты
 *
 * @package Cash
 * @author eMarket
 * 
 */
class Cash {

    /**
     * Инсталляция модуля
     *
     * @param array $module (входящие данные)
     */
    public static function install($module) {
        // Инсталлируем
        \eMarket\Modules::install($module);
    }

    /**
     * Удаление модуля
     *
     * @param array $module (входящие данные)
     */
    public static function uninstall($module) {
        // Удаляем
        \eMarket\Modules::uninstall($module);
    }

    /**
     * Загрузка данных по модулю
     *
     * @param array $zones_id (данные по используемым зонам)
     * @return array|FALSE $interface (выходные данные)
     */
    public static function load($zones_id) {


    }

}

?>
