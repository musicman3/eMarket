<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Lang,
    Settings
};
?>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#product_<?php echo lang('#lang_all')[0] ?>"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[0] ?>.png" alt="<?php echo lang('#lang_all')[0] ?>" title="<?php echo lang('#lang_all')[0] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[0]) ?></a>
    </li>

    <?php
    if (Lang::$count > 1) {
        for ($x = 1; $x < Lang::$count; $x++) {
            ?>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#product_<?php echo lang('#lang_all')[$x] ?>"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[$x] ?>.png" alt="<?php echo lang('#lang_all')[$x] ?>" title="<?php echo lang('#lang_all')[$x] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[$x]) ?></a>
            </li>

            <?php
        }
    }
    ?>

</ul>