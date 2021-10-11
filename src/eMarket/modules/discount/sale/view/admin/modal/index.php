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
            <div class="modal-header">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form_add_mod" class="was-validated" name="form_add_mod" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_add_mod')">
                <div class="modal-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

                    <div class="tab-content pt-2">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade show in active">
                            <small class="form-text text-muted" for="name_module_0"><?php echo lang('modules_discount_sale_admin_name') ?></small>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('modules_discount_sale_admin_enter_value') ?>" type="text" name="name_module_0" id="name_module_0" required />
                            </div>
                        </div>

                        <?php
                        if (Lang::$count > 1) {
                            for ($x = 1; $x < Lang::$count; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <small class="form-text text-muted" for="name_module_<?php echo $x ?>"><?php echo lang('modules_discount_sale_admin_name') ?></small>
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text bi-file-text"></span>
                                        <input class="form-control" placeholder="<?php echo lang('modules_discount_sale_admin_enter_value') ?>" type="text" name="name_module_<?php echo $x ?>" id="name_module_<?php echo $x ?>" required />
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        <div class="mb-2">
                            <small class="form-text text-muted" for="start_date"><?php echo lang('modules_discount_sale_admin_sale_start_date') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-calendar"></span>
                                <input class="form-control" placeholder="<?php echo lang('modules_discount_sale_admin_enter_date') ?>" type="text" name="start_date" id="start_date" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted" for="end_date"><?php echo lang('modules_discount_sale_admin_sale_end_date') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-calendar"></span>
                                <input class="form-control" placeholder="<?php echo lang('modules_discount_sale_admin_enter_date') ?>" type="text" name="end_date" id="end_date" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted" for="sale_value"><?php echo lang('modules_discount_sale_admin_value') ?></small>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text bi-sort-numeric-down"></span>
                                <input class="form-control" placeholder="<?php echo lang('modules_discount_sale_admin_enter_value') ?>" type="text" name="sale_value" pattern="\d+(\.\d{0,2})?" id="sale_value" required />
                            </div>
                        </div>
                        <div class="mb-2 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="default_module" id="default_module" checked>
                            <label class="form-check-label" for="default_module"><?php echo lang('default_set') ?></label>
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