<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$products = $PRODUCTS->productData($VALID->inGET('id'))[0];
$product_category = $PRODUCTS->productCategories($products[5]);
$product_price = $PRODUCTS->productPrice($products[12], $CURRENCIES, 1);

?>