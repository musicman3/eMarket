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
                            <div class="mb-2">
                                <small class="form-text text-muted"><?php echo lang('vendor_codes_name') ?></small>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bi-file-text"></span>
                                    <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name_vendor_codes_0" id="name_vendor_codes_0" required />
                                </div>
                            </div>
                            <div class="mb-2">
                                <small class="form-text text-muted"><?php echo lang('vendor_codes_description') ?></small>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bi-file-text"></span>
                                    <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="vendor_code_0" id="vendor_code_0" />
                                </div>
                            </div>
                        </div>

                        <?php
                        if (Lang::$count > 1) {
                            for ($x = 1; $x < Lang::$count; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <div class="mb-2">
                                        <small class="form-text text-muted"><?php echo lang('vendor_codes_name') ?></small>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bi-file-text"></span>
                                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name_vendor_codes_<?php echo $x ?>" id="name_vendor_codes_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="form-text text-muted"><?php echo lang('vendor_codes_description') ?></small>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bi-file-text"></span>
                                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="vendor_code_<?php echo $x ?>" id="vendor_code_<?php echo $x ?>" />
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        
                        <div class="mb-2 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="default_vendor_code" id="default_vendor_code" checked>
                            <label class="form-check-label" for="default_vendor_code"><?php echo lang('default_set') ?></label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm bi-x-circle" type="button" data-bs-dismiss="modal"> <?php echo lang('cancel') ?></button>
                    <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>