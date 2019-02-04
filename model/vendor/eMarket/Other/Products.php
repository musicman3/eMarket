<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Other;

/**
 * Класс для работы с товарами
 *
 * @package Product
 * @author eMarket
 * 
 */
class Products {

    /**
     * Данные по товару
     *
     * @param string $count (количество новых товаров)
     * @return array $product (массив с данными по товару)
     */
    public function viewNew($count) {
        $PDO = new \eMarket\Core\Pdo;

        $product = $PDO->getColRow("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? ORDER BY id DESC LIMIT " . $count . "", [lang('#lang_all')[0]]);
        return $product;
    }

}

?>