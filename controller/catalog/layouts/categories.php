<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$sql = \eMarket\Pdo::getObj("SELECT id, name, status, parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? AND status>0 ORDER BY sort_category DESC", [lang('#lang_all')[0]]);

?>