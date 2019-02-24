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
    
    /**
     * Данные по товару
     *
     * @param string $id (id товара)
     * @return array $product (данные по товару)
     */
    public function productData($id) {
        $PDO = new \eMarket\Core\Pdo;

        $product = $PDO->getColRow("SELECT * FROM " . TABLE_PRODUCTS . " WHERE language=? AND id=?", [lang('#lang_all')[0], $id]);
        return $product;
    }
    
    /**
     * Изображения товара
     *
     * @param string $products_new_count (номер товара)
     * @return array $image (названия изображений в массиве)
     */
    public function viewNewImages($products_new_count) {
        $image = explode(',', $products_new_count[6], -1);
        return $image;
    }    

}

?>