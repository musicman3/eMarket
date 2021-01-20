<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h1><?php echo lang('index_text') ?></h1>

<?php
foreach (\eMarket\Core\View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}