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
            $price_val = $input[5];
        } else {
            $discount_val = $input['discount'];
            $price_val = $input['price'];
        }

        if ($discount_val != '' && $discount_val != NULL && self::status() == 1) {

            $explode_id = explode(',', $discount_val);
            $discount_out = 0;
            $discount_name_out = '';
            $discount_count = 0;

            foreach ($explode_id as $val) {
                $data = \eMarket\Pdo::getRow("SELECT sale_value, name, UNIX_TIMESTAMP (date_start), UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=? AND id=?", [lang('#lang_all')[0], $val]);
                $discount = $data[0];
                $discount_name = $data[1];

                $this_time = time();
                $date_start = $data[2];
                $date_end = $data[3];

                if ($this_time > $date_start && $this_time < $date_end) {
                    $discount_out = $discount_out + $discount;
                    $discount_name_out .= $discount_name . '<br>';
                    $discount_count++;
                }
            }
            $price = $price_val / 100 * (100 - $discount_out);

            return [$price, $discount_name_out, $discount_count, $discount_out];
        }
        return [$price_val];
    }

}

?>
