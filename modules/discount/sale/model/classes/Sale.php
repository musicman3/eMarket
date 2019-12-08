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
    private static function data($input) {

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
                $discount = \eMarket\Pdo::getCell("SELECT sale_value FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=? AND id=?", [lang('#lang_all')[0], $val]);
                $discount_name = \eMarket\Pdo::getCell("SELECT name FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=? AND id=?", [lang('#lang_all')[0], $val]);

                $this_time = time();
                $date_start = \eMarket\Pdo::getCell("SELECT UNIX_TIMESTAMP (date_start) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE id=?", [$val]);
                $date_end = \eMarket\Pdo::getCell("SELECT UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE id=?", [$val]);

                if ($this_time > $date_start && $this_time < $date_end) {
                    $discount_out = $discount_out + $discount;
                    $discount_name_out .= $discount_name . '<br>';
                    $discount_count++;
                }
            }
            $price = $price_val / 100 * (100 - $discount_out);

            return [$price, $discount_name_out, $discount_count];
        }
        return [$price_val];
    }

    /**
     * Блок формирования итоговой скидки на заказ
     * 
     * @param array $input (массив с входящими значениями по товару)
     * @param string $CURRENCIES (валюта)
     * @param string $marker (маркер для \eMarket\Products::productPrice для вывода названия валюты)
     * @param string $class (класс bootstrap для отображения скидки)
     * @return string (выходные данные в виде форматированной стоимости)
     */
    public static function interface($input, $CURRENCIES, $marker, $class = null) {

        if ($class == null) {
            $class = 'danger';
        }

        if (\eMarket\Set::path() == 'admin') {
            $price_val = $input[5];
            $price_with_sale = self::data($input);

            if ($price_val != $price_with_sale[0] && $price_with_sale[2] == 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . $price_with_sale[1] . '" class="label label-' . $class . '">' . \eMarket\Products::productPrice($price_with_sale[0], $CURRENCIES, $marker) . '</span> <del>' . \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '</del>';
            }
            if ($price_val != $price_with_sale[0] && $price_with_sale[2] > 1) {
                return '<span data-toggle="tooltip" data-placement="left" data-html="true" data-original-title="' . lang('modules_discount_sale_admin_tooltip_warning') . $price_with_sale[1] . '" class="label label-warning"><u>' . \eMarket\Products::productPrice($price_with_sale[0], $CURRENCIES, $marker) . '</u></span> <del>' . \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '</del>';
            }
            return \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker);
        }

        if (\eMarket\Set::path() == 'catalog') {
            $price_val = $input['price'];
            $price_with_sale = self::data($input);

            if ($price_val != $price_with_sale[0]) {
                return '<del>' . \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '</del><br><span class="label label-' . $class . '">' . \eMarket\Products::productPrice($price_with_sale[0], $CURRENCIES, $marker) . '</span>';
            }
            return \eMarket\Products::productPrice($price_val, $CURRENCIES, $marker) . '<br><br>';
        }
    }

}

?>
