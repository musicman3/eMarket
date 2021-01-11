<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$product_edit = json_encode([]);
for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
    if (isset($lines[$i]['id']) == TRUE) {

        $modal_id = $lines[$i]['id'];

        $query = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_PRODUCTS . " WHERE id=? and language=?", [$modal_id, lang('#lang_all')[0]])[0];
        $product_temp[$modal_id] = $query;
        $product_temp[$modal_id]['price_formated'] = \eMarket\Ecb::priceInterface($query, 1);

        $product_edit = json_encode($product_temp);
    }
}
?>
