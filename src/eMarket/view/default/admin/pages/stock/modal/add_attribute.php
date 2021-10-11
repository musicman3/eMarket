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

<div id="add_attribute" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h5 class="modal-title"><?php echo lang('stock_tittle_specification_name') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="attribute_add_form" class="was-validated">
                <div class="modal-body">

                    <div class="mb-3">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[0] ?>.png" alt="<?php echo lang('#lang_all')[0] ?>" title="<?php echo lang('#lang_all')[0] ?>" width="16" height="10" /></span>
                            <input class="input-add-attribute form-control" placeholder="<?php echo lang('name') ?>" type="text" name="attribute_<?php echo lang('#lang_all')[0] ?>" required />
                        </div>
                    </div>

                    <?php
                    if (Lang::$count > 1) {
                        for ($x = 1; $x < Lang::$count; $x++) {
                            ?>
                            <div class="mb-3">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text"><img src="/view/<?php echo Settings::template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[$x] ?>.png" alt="<?php echo lang('#lang_all')[$x] ?>" title="<?php echo lang('#lang_all')[$x] ?>" width="16" height="10" /></span>
                                    <input class="input-add-attribute form-control" placeholder="<?php echo lang('name') ?>" type="text" name="attribute_<?php echo lang('#lang_all')[$x] ?>" required />
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>

                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-primary btn-sm bi-x-circle" type="button" data-bs-dismiss="modal"> <?php echo lang('cancel') ?></button>
                <button id="save_attribute_button" class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
            </div>
        </div>
    </div>
</div>
