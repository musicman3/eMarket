<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

/**
 * Класс для работы с корзиной
 *
 * @package Cart
 * @author eMarket
 * 
 */
class Cart {

    /**
     * Добавить товар в корзину
     *
     * @param string $id (ID товара)
     */
    public function add($id, $quantity) {

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = ['id' => $id, 'quantity' => $quantity];
        } else {
            $_SESSION['cart'] = ['id' => 2, 'quantity' => 2];
        }
    }

}

?>