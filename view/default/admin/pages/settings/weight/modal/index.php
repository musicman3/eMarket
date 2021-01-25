<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Lang,
    Settings
};
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
                <div class="modal-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade show in active">
                            <div class="mb-2">
                                <small class="form-text text-muted"><?php echo lang('weight_name_full') ?></small>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="bi-file-text"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name_weight_0" id="name_weight_0" required />
                                </div>
                            </div>
                            <div class="mb-2">
                                <small class="form-text text-muted"><?php echo lang('weight_name_little') ?></small>
                                <div class="input-group">
                                    <span class="input-group-text"><span class="bi-file-text"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="code_weight_0" id="code_weight_0" required />
                                </div>
                            </div>
                        </div>

                        <?php
                        if (Lang::$count > 1) {
                            for ($x = 1; $x < Lang::$count; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <div class="mb-2">
                                        <small class="form-text text-muted"><?php echo lang('weight_name_full') ?></small>
                                        <div class="input-group">
                                            <span class="input-group-text"><span class="bi-file-text"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name_weight_<?php echo $x ?>" id="name_weight_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="form-text text-muted"><?php echo lang('weight_name_little') ?></small>
                                        <div class="input-group">
                                            <span class="input-group-text"><span class="bi-file-text"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="code_weight_<?php echo $x ?>" id="code_weight_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>

                        <div class="mb-2">
                            <small class="form-text text-muted"><?php echo lang('weight_value') ?></small>
                            <div class="input-group">
                                <span class="input-group-text"><span class="bi-calculator"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="value_weight" pattern="\d+(\.\d{0,7})?" id="value_weight" required />
                            </div>
                        </div>
                        <div class="mb-2 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="default_weight" id="default_weight" checked>
                            <label class="form-check-label" for="default_weight"><?php echo lang('default_set') ?></label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="button" data-bs-dismiss="modal"><span class="bi-x-circle"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-sm"><span class="bi-check-circle"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>