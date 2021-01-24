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
                            <div class="mb-3">
                                <div class="input-group has-error">
                                    <span class="input-group-text"><span class="bi-file-text"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('taxes_modal_name') ?>" type="text" name="name_taxes_0" id="name_taxes_0" required />
                                </div>
                            </div>
                        </div>

                        <?php
                        if (Lang::$count > 1) {
                            for ($x = 1; $x < Lang::$count; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <div class="mb-3">
                                        <div class="input-group has-error">
                                            <span class="input-group-text"><span class="bi-file-text"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('taxes_modal_name') ?>" type="text" name="name_taxes_<?php echo $x ?>" id="name_taxes_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>

                        <div class="mb-3">
                            <div class="input-group has-error">
                                <span class="input-group-text"><?php echo Settings::currencyDefault()[3] ?></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('taxes_modal_rate') ?>" type="text" pattern="\d+(\.\d{0,2})?" name="rate_taxes" id="rate_taxes" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-handle-width="70" data-on-text="<?php echo lang('taxes_modal_percent') ?>" data-off-text="<?php echo lang('taxes_modal_value') ?>" name="fixed" id="fixed" checked>
                            <br><small class="form-text text-muted"><?php echo lang('taxes_modal_fixed_desc') ?></small>
                        </div>
                        <div class="mb-3">
                            <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-handle-width="70" data-on-text="<?php echo lang('taxes_modal_included') ?>" data-off-text="<?php echo lang('taxes_modal_separately') ?>" name="tax_type" id="tax_type" checked>
                            <br><small class="form-text text-muted"><?php echo lang('taxes_modal_included_desc') ?></small>
                        </div>
                        <div class="mb-3">
                            <div class="input-group has-success">
                                <span class="input-group-text"><span class="bi-pen"></span></span>
                                <select name="zones_id" id="zones_id" class="input-sm form-control"></select>
                            </div>
                            <small class="form-text text-muted"><?php echo lang('taxes_modal_zones_desc') ?></small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>