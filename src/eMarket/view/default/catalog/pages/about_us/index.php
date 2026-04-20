<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages
};
use eMarket\Admin\Templates;
use eMarket\Catalog\AboutUs;

foreach (Templates::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
?>

<div id="alert_block"><?php Messages::alert(); ?></div>
<h1><?php echo lang('about_us_name') ?></h1>

<div id="login" class="contentText">

    <div class="card">
        <div class="card-body">
            <?php echo AboutUs::$description ?>
        </div>
    </div>


</div>
