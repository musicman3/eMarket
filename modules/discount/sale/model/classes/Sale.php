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
 * Класс для валидации данных
 *
 * @package Sale
 * @author eMarket
 * 
 */
class Sale {

    /**
     * Выходные данные для внутреннего интерфейса калькулятора
     *
     * @param array $input (массив с входящими значениями id, price, discount)
     * @return array $output (массив с выодящими значениями id, price, discount)
     */
    public static function interface($input, $CURRENCIES) {

        if ($input['discount'] != '' && $input['discount'] != NULL) {

            $explode_id = explode(',', $input['discount']);
            $discount_out = 0;
            foreach ($explode_id as $val) {
                $discount = \eMarket\Pdo::getCell("SELECT sale_value FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=? AND id=?", [lang('#lang_all')[0], $val]);
                
                $this_time = time();
                $date_start = \eMarket\Pdo::getCell("SELECT UNIX_TIMESTAMP (date_start) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE id=?", [$val]);
                $date_end = \eMarket\Pdo::getCell("SELECT UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE id=?", [$val]);
                
                if ($this_time > $date_start && $this_time < $date_end) {
                    $discount_out = $discount_out + $discount;
                }
                
                $price = $input['price'] / 100 * (100 - $discount_out);
            }

            if ($this_time > $date_start && $this_time < $date_end) {
                return '<del>' . \eMarket\Products::productPrice($input['price'], $CURRENCIES, 1) . '</del><br><span class="label label-danger">' . \eMarket\Products::productPrice($price, $CURRENCIES, 1) . '</span>';
            }
            return \eMarket\Products::productPrice($input['price'], $CURRENCIES, 1);
        }
        return \eMarket\Products::productPrice($input['price'], $CURRENCIES, 1);
    }

}

?>
