<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h3>eMarket Bootstrap 3 Demo</h3>

<?php
// ПОДКЛЮЧАЕМ БОКС КОНТЕНТА
foreach ($VIEW->layoutRouting($VIEW->layoutRoutingFilter('content-center')) as $path) {
    require_once (getenv('DOCUMENT_ROOT') . $path);
}

?>