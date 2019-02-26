<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$sql = $PDO->getObj("SELECT id, name, parent_id FROM " . TABLE_CATEGORIES . " WHERE language=? ORDER BY sort_category DESC", [lang('#lang_all')[0]]);

?>