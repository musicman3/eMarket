<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

$products = $PDO->getColRow("SELECT id, name, logo_general, price, description FROM " . TABLE_PRODUCTS . " WHERE language=? AND parent_id=? ORDER BY date_added DESC", [lang('#lang_all')[0], $VALID->inGET('category_id')]);

//$DEBUG->trace($image);
/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */

?>