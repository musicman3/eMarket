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
<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form_add" class="was-validated" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
                <div class="modal-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

                    <div class="tab-content pt-2">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade show in active">
                            <small class="form-text text-muted" for="name_zones_0"><?php echo lang('name_zone') ?></small>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name_zones_0" id="name_zones_0" required />
                            </div>
                        </div>

                        <?php
                        if (Lang::$count > 1) {
                            for ($x = 1; $x < Lang::$count; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <small class="form-text text-muted" for="name_zones_<?php echo $x ?>"><?php echo lang('name_zone') ?></small>
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text bi-file-text"></span>
                                        <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name_zones_<?php echo $x ?>" id="name_zones_<?php echo $x ?>" required />
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        <div class="mb-2">
                            <div><small class="form-text text-muted"><?php echo lang('name_description') ?></small></div>
                            <textarea class="input-sm form-control" placeholder="<?php echo lang('add_name_description') ?>" rows="5" name="note_zones" id="note_zones"></textarea>
                        </div> 
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="button bi-x-circle" data-bs-dismiss="modal"> <?php echo lang('cancel') ?></button>
                    <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>