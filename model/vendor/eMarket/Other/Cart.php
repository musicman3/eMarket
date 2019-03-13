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
    public function add($id, $quantity = null) {
        
        $count = 0;
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [['id' => $id, 'quantity' => $quantity]];
        } else {
            foreach ($_SESSION['cart'] as $value) {
                if ($value['id'] != $id) {
                    array_push($_SESSION['cart'], ['id' => $id, 'quantity' => $quantity]);
                } elseif ($value['id'] == $id) {
                    $_SESSION['cart'][$count]['quantity'] = $_SESSION['cart'][$count]['quantity'] + $quantity;
                }
                $count++;
            }
        }
    }

}

?>