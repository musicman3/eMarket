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

namespace eMarket\Modules\Discount;

/**
 * Класс модуля скидок
 *
 * @package Sale
 * @author eMarket
 * 
 */
class Sale {

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
        // Очищаем поле распродажи
        \eMarket\Pdo::inPrepare("UPDATE " . TABLE_PRODUCTS . " SET discount=?", ['']);
    }

    /**
     * Данные по статусу модуля
     *
     * @return string|FALSE (данные по статусу модуля)
     */
    public static function status() {
        $module_active = \eMarket\Pdo::getCellFalse("SELECT active FROM " . TABLE_MODULES . " WHERE name=? AND type=?", ['sale', 'discount']);
        return $module_active;
    }

    /**
     * Выходные данные для внутреннего интерфейса калькулятора
     *
     * @param array $input (массив с входящими значениями по товару)
     * @return array (выходные данные по цене)
     */
    public static function dataInterface($input) {

        if (\eMarket\Set::path() == 'admin') {
            $discount_val = $input[4];
            $currency = $input[8];
            $price_val = \eMarket\Products::currencyPrice($input[5], $currency);
        } else {
            $discount_val = $input['discount'];
            $currency = $input['currency'];
            $price_val = \eMarket\Products::currencyPrice($input['price'], $currency);
        }

        if ($discount_val != '' && $discount_val != NULL && self::status() == 1) {

            $explode_id = explode(',', $discount_val);
            $discount_out = [];
            $discount_names = [];

            foreach ($explode_id as $val) {
                $data = \eMarket\Pdo::getRow("SELECT sale_value, name, UNIX_TIMESTAMP (date_start), UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=? AND id=?", [lang('#lang_all')[0], $val]);

                $this_time = time();
                $date_start = $data[2];
                $date_end = $data[3];

                if ($this_time > $date_start && $this_time < $date_end) {
                    array_push($discount_out, $data[0]);
                    array_push($discount_names, $data[1]);
                }
            }
            
            $total_rate = 0;
            foreach ($discount_out as $rate) {
                $total_rate = $total_rate + $rate;
            }

            $price = $price_val / 100 * (100 - $total_rate);

            return ['price' => $price, 'names' => $discount_names, 'sales' => $discount_out];
        }
        return ['price' => $price_val, 'names' => 'false', 'sales' => 'false'];
    }

}

?>
