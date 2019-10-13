<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Движок ECB (Easy Calculated Block) v.1.0
 *
 * @package Ecb
 * @author eMarket
 * 
 */
final class Ecb {

    /**
     * Инициализация ECB
     * @param 1
     * @return array array()
     */
    public function init() {
        //echo ('test');
    }

    /**
     * Блок формирования входящей стоимости
     * @param array $cart (данные из корзины)
     * @return array $output (выходные данные)
     */
    public function inputPrice($cart) {
        //echo ($output);
    }

    /**
     * Блок формирования скидки на товар
     * @param array $input (данные из inputPrice)
     * @return array $output (выходные данные)
     */
    public function productSaleBlock($input) {
        //echo ($output);
    }

    /**
     * Блок формирования итоговой скидки на заказ
     * @param array $input (данные из productSaleBlock)
     * @return array $output (выходные данные)
     */
    public function totalSaleBlock($input) {
        //echo ($output);
    }

    /**
     * Блок формирования стоимости доставки
     * @param array $input (данные из totalSaleBlock)
     * @return array $output (выходные данные)
     */
    public function shippingBlock($input) {
        //echo ($output);
    }

    /**
     * Блок формирования оплаты
     * @param array $input (данные из shippingBlock)
     * @return array $output (выходные данные)
     */
    public function checkoutBlock($input) {
        //echo ($output);
    }

    /**
     * Блок формирования исходящей стоимости
     * @param array $input (данные из checkoutBlock)
     * @return array $output (выходные данные)
     */
    public function outputPrice($input) {
        //echo ($output);
    }

}

?>