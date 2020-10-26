<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$categories = \eMarket\Pdo::getColRow("SELECT id, name, logo_general, status FROM " . TABLE_CATEGORIES . " WHERE language=? AND parent_id=? AND status=1 ORDER BY sort_category DESC", [lang('#lang_all')[0], \eMarket\Valid::inGET('category_id')]);

?>