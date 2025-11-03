<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div class="contentText mb-2 p-3 border rounded">
    <?php if (\eMarket\Core\Authorize::$customer == FALSE) { ?>
        <h3 class="text-center"><?php echo sprintf(lang('welcome_name'), lang('welcome_guest')) ?></h3>
        <p class="text-center"><?php echo sprintf(lang('welcome_text')) ?></p>
    <?php } else { ?>
        <h3 class="text-center"><?php echo sprintf(lang('welcome_name'), \eMarket\Core\Authorize::$customer['firstname']) ?></h3>
        <p class="text-center"> </p>
    <?php } ?>
</div>
