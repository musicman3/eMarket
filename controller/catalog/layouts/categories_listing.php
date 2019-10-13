<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$categories = \eMarket\Core\Pdo::getColRow("SELECT id, name, logo_general FROM " . TABLE_CATEGORIES . " WHERE language=? AND parent_id=? ORDER BY sort_category DESC", [lang('#lang_all')[0], $VALID->inGET('category_id')]);

?>