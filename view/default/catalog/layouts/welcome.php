<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div class="contentText">
    <?php if ($CUSTOMER == FALSE) { ?>
        <h4><?php echo sprintf(lang('welcome_name'), lang('welcome_guest')) ?></h4>
        <p><?php echo sprintf(lang('welcome_text')) ?></p>
    <?php } else { ?>
        <h4><?php echo sprintf(lang('welcome_name'), $CUSTOMER['firstname']) ?></h4>
        <p> </p>
    <?php } ?>
</div>