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
     * @return array $interface (выходные данные)
     */
    public static function load() {

        // Интерфейс для модулей доставки
        $interface = [
            'chanel_module_name' => 'cash',
            'chanel_name' => lang('modules_payment_cash_name'),
            'chanel_payment_price' => 0,
            'chanel_payment_currency' => '',
            'chanel_image' => ''
        ];

        return $interface;
    }

}

?>
