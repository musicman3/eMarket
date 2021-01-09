<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h1>eMarket Bootstrap 3 Demo</h1>

<?php
// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::TLPC('content') as $path) {
    require_once (ROOT . $path);
}

?>