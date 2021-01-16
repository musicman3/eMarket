<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\Core\View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
?>

<!--Выводим уведомление об успешном действии-->
<div id="alert_block"><?php \eMarket\Core\Messages::alert(); ?></div>
<h1><?php echo lang('success_text') ?></h1>

<div id="success" class="contentText"><?php echo lang('success_message') ?></div>