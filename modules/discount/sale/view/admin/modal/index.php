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
            <form id="form_add_mod" name="form_add_mod" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_add_mod')">
                <div class="modal-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><span class="bi-file-text"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_name') ?>" type="text" name="name_module_0" id="name_module_0" required />
                            </div>
                        </div>

                        <?php
                        if (Lang::$count > 1) {
                            for ($x = 1; $x < Lang::$count; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><span class="bi-file-text"></span></span>
                                        <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_name') ?>" type="text" name="name_module_<?php echo $x ?>" id="name_module_<?php echo $x ?>" required />
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><span class="bi-calendar"></span></span>
                            <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_sale_start_date') ?>" type="text" name="start_date" id="start_date" autocomplete="off" required />
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group has-error">
                                <span class="input-group-text"><span class="bi-calendar"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_sale_end_date') ?>" type="text" name="end_date" id="end_date" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><span class="bi-sort-numeric-down"></span></span>
                            <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_value') ?>" type="text" name="sale_value" pattern="\d+(\.\d{0,2})?" id="sale_value" required />
                        </div>
                        <div class="mb-2 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="default_module" id="default_module" checked>
                            <label class="form-check-label" for="default_module"><?php echo lang('default_set') ?></label>
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