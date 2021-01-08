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
        $products_data = \eMarket\Pdo::getColAssoc("SELECT id, discount FROM " . TABLE_PRODUCTS . " WHERE language=?", [lang('#lang_all')[0]]);
        foreach ($products_data as $data) {
            $discounts = json_decode($data['discount'], 1);
            unset($discounts['sale']);
            \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discounts), $data['id']]);
        }
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
     * @param string $language (язык)
     * @return array (выходные данные по цене)
     */
    public static function dataInterface($input, $language = null) {

        if ($language == null) {
            $language = lang('#lang_all')[0];
        }

        $discount_val = json_decode($input['discount'], 1);
        $currency = $input['currency'];
        $input_price = \eMarket\Ecb::currencyPrice($input['price'], $currency);

        if (array_key_exists('sale', $discount_val) && count($discount_val['sale']) > 0 && self::status() != FALSE && self::status() == 1) {

            $discount_out = [];
            $discount_names = [];

            foreach ($discount_val['sale'] as $val) {
                $data = \eMarket\Pdo::getColAssoc("SELECT sale_value, name, UNIX_TIMESTAMP (date_start), UNIX_TIMESTAMP (date_end) FROM " . DB_PREFIX . 'modules_discount_sale' . " WHERE language=? AND id=?", [$language, $val])[0];
                if (count($data) > 0) {
                    $this_time = time();
                    $date_start = $data['UNIX_TIMESTAMP (date_start)'];
                    $date_end = $data['UNIX_TIMESTAMP (date_end)'];

                    if ($this_time > $date_start && $this_time < $date_end) {
                        array_push($discount_out, $data['sale_value']);
                        array_push($discount_names, lang('modules_discount_sale_name') . ': ' . $data['name'] . ' (' . $data['sale_value'] . '%)');
                    }
                }
            }

            $total_rate = 0;
            foreach ($discount_out as $rate) {
                $total_rate = $total_rate + $rate;
            }

            $out_price = $input_price / 100 * (100 - $total_rate);

            $interface = [
                'price' => $out_price,
                'names' => $discount_names,
                'sales' => $discount_out
            ];

            return $interface;
        }

        $interface = [
            'price' => $input_price,
            'names' => 'false',
            'sales' => 'false'
        ];
        return $interface;
    }

    /**
     * Инициализация в EAC / EAC init
     */
    public static function initEac() {

        if ((\eMarket\Valid::inPOST('idsx_sale_on_key') == 'On')
                or ( \eMarket\Valid::inPOST('idsx_sale_off_key') == 'Off')
                or ( \eMarket\Valid::inPOST('idsx_sale_off_all_key') == 'OffAll')) {

            $parent_id_real = (int) \eMarket\Valid::inPOST('idsx_real_parent_id');

            if (\eMarket\Valid::inPOST('idsx_sale_on_key') == 'On') {
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_sale_on_id'));
                $discount = \eMarket\Valid::inPOST('sale');
            }

            if (\eMarket\Valid::inPOST('idsx_sale_off_key') == 'Off') {
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_sale_off_id'));
                $discount = \eMarket\Valid::inPOST('sale');
            }

            if (\eMarket\Valid::inPOST('idsx_sale_off_all_key') == 'OffAll') {
                $idx = \eMarket\Func::deleteEmptyInArray(\eMarket\Valid::inPOST('idsx_sale_off_all_id'));
                $discount = \eMarket\Valid::inPOST('sale');
            }

            if (!is_array($idx)) {
                $idx = [];
            }

            for ($i = 0; $i < count($idx); $i++) {
                if (strstr($idx[$i], '_', true) != 'product') {
                    // Это категория / This is category
                    \eMarket\Eac::$parent_id = \eMarket\Eac::dataParentId($idx[$i]);
                    $keys = \eMarket\Eac::dataKeys($idx[$i]);

                    $count_keys = count($keys);
                    for ($x = 0; $x < $count_keys; $x++) {

                        if (\eMarket\Valid::inPOST('idsx_sale_on_key') == 'On') {
                            // Это товар / This is product
                            $products_id = \eMarket\Pdo::getColAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = \eMarket\Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, 1);

                                if (!array_key_exists('sale', $discount_array)) {
                                    $discount_array['sale'] = [$discount];
                                } else {
                                    if (!in_array($discount, $discount_array['sale'])) {
                                        array_push($discount_array['sale'], $discount);
                                    }
                                }

                                \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $val['id']]);
                            }

                            if ($parent_id_real > 0) {
                                \eMarket\Eac::$parent_id = $parent_id_real;
                            }
                        }
                        if (\eMarket\Valid::inPOST('idsx_sale_off_key') == 'Off') {
                            // Это товар / This is product
                            $products_id = \eMarket\Pdo::getColAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = \eMarket\Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, 1);

                                if (array_key_exists('sale', $discount_array)) {
                                    foreach ($discount_array['sale'] as $key_del => $name_del) {
                                        if ($name_del == $discount) {
                                            unset($discount_array['sale'][$key_del]);
                                        }
                                    }
                                }

                                \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $val['id']]);
                            }

                            if ($parent_id_real > 0) {
                                \eMarket\Eac::$parent_id = $parent_id_real;
                            }
                        }
                        if (\eMarket\Valid::inPOST('idsx_sale_off_all_key') == 'OffAll') {
                            // Это товар / This is product
                            $products_id = \eMarket\Pdo::getColAssoc("SELECT id FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=?", [lang('#lang_all')[0], $keys[$x]]);

                            foreach ($products_id as $val) {
                                $discount_json = \eMarket\Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$val['id']]);
                                $discount_array = json_decode($discount_json, 1);

                                if (array_key_exists('sale', $discount_array)) {
                                    unset($discount_array['sale']);
                                }

                                \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $val['id']]);
                            }

                            if ($parent_id_real > 0) {
                                \eMarket\Eac::$parent_id = $parent_id_real;
                            }
                        }
                    }
                } else {
                    // Это товар / This is product
                    //Обновляем статус основного товара / Update gengeral product status
                    if (\eMarket\Valid::inPOST('idsx_sale_on_key') == 'On') {
                        $id_prod = explode('product_', $idx[$i]);
                        $discount_json = \eMarket\Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, 1);

                        if (!array_key_exists('sale', $discount_array)) {
                            $discount_array['sale'] = [$discount];
                        } else {
                            if (!in_array($discount, $discount_array['sale'])) {
                                array_push($discount_array['sale'], $discount);
                            }
                        }

                        \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
                    }
                    if (\eMarket\Valid::inPOST('idsx_sale_off_key') == 'Off') {
                        $id_prod = explode('product_', $idx[$i]);
                        $discount_json = \eMarket\Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, 1);

                        if (array_key_exists('sale', $discount_array)) {
                            foreach ($discount_array['sale'] as $key_del => $name_del) {
                                if ($name_del == $discount) {
                                    unset($discount_array['sale'][$key_del]);
                                }
                            }
                        }

                        \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
                    }
                    if (\eMarket\Valid::inPOST('idsx_sale_off_all_key') == 'OffAll') {
                        $id_prod = explode('product_', $idx[$i]);
                        $discount_json = \eMarket\Pdo::getCell("SELECT discount FROM " . TABLE_PRODUCTS . " WHERE id=?", [$id_prod[1]]);
                        $discount_array = json_decode($discount_json, 1);

                        if (array_key_exists('sale', $discount_array)) {
                            unset($discount_array['sale']);
                        }
                        \eMarket\Pdo::action("UPDATE " . TABLE_PRODUCTS . " SET discount=? WHERE id=?", [json_encode($discount_array), $id_prod[1]]);
                    }
                }
            }
        }

        if (is_array(\eMarket\Eac::$parent_id) == TRUE) {
            \eMarket\Eac::$parent_id = 0;
        }
    }

}

?>
