<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Messages,
    View
};

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
?>

<div id="alert_block"><?php Messages::alert(); ?></div>
<h1><?php echo lang('success_text') ?></h1>

<div id="success" class="contentText">
    <div class="bg-light border rounded mb-3 py-3 px-2">
	<p class="card-text"><?php echo lang('success_message') ?></p>
    </div>
    <form>
        <input hidden name="route" value="orders">
        <div class="text-end">
            <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
        </div>
    </form>
</div>