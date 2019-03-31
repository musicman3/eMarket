<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div class="contentText">
    <?php if ($CUSTOMER == FALSE) { ?>
        <h4><?php echo sprintf(lang('welcome_name'), lang('welcome_guest')) ?></h4>
    <?php } else { ?>
        <h4><?php echo sprintf(lang('welcome_name'), $CUSTOMER['firstname']) ?></h4>
    <?php } ?>
    <p>The default shopping cart comes with Jquery UI, Grid960, Fancybox and BxGallery, in this demo those have been replaced by Boostrap and Bootstrap 3 Lightbox making it lighter, faster and responsive.</p>
</div>