<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Языковые панели -->
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#<?php echo lang('#lang_all')[0] . $modal_id ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[0] ?>.png" alt="<?php echo lang('#lang_all')[0] ?>" title="<?php echo lang('#lang_all')[0] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[0]) ?></a></li>

    <?php
    if ($LANG_COUNT > 1) {
        for ($xl = 1; $xl < $LANG_COUNT; $xl++) {
            ?>

            <li><a data-toggle="tab" href="#<?php echo lang('#lang_all')[$xl] . $modal_id ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[$xl] ?>.png" alt="<?php echo lang('#lang_all')[$xl] ?>" title="<?php echo lang('#lang_all')[$xl] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[$xl]) ?></a></li>

        <?php
    }
}
?>

</ul>