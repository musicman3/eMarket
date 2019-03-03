<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$products = $PDO->getColRow("SELECT id, name, logo_general, price, description FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=? ORDER BY date_added DESC", [lang('#lang_all')[0], $VALID->inGET('category_id')]);

?>