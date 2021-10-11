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
                                <small class="form-text text-muted"><?php echo lang('currencies_name_full') ?></small>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bi-file-text"></span>
                                    <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name_currencies_0" id="name_currencies_0" required />
                                </div>
                            </div>
                            <div class="mb-2">
                                <small class="form-text text-muted"><?php echo lang('currencies_name_little') ?></small>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text bi-file-text"></span>
                                    <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="code_currencies_0" id="code_currencies_0" required />
                                </div>
                            </div>
                        </div>

                        <?php
                        if (Lang::$count > 1) {
                            for ($x = 1; $x < Lang::$count; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <div class="mb-2">
                                        <small class="form-text text-muted"><?php echo lang('currencies_name_full') ?></small>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bi-file-text"></span>
                                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name_currencies_<?php echo $x ?>" id="name_currencies_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="form-text text-muted"><?php echo lang('currencies_name_little') ?></small>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bi-file-text"></span>
                                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="code_currencies_<?php echo $x ?>" id="code_currencies_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        <div class="mb-2">
                            <small class="form-text text-muted"><?php echo lang('currencies_iso_4217') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" pattern="[A-Za-z]{3}" name="iso_4217_currencies" id="iso_4217_currencies" required />
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted"><?php echo lang('currencies_currency_symbol') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="symbol_currencies" id="symbol_currencies" required />
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted"><?php echo lang('currencies_position') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-arrow-down-up"></span>
                                <select name="symbol_position_currencies" id="symbol_position_currencies" class="form-select">
                                    <option value="right"><?php echo lang('currencies_symbol_right') ?></option>
                                    <option value="left" selected><?php echo lang('currencies_symbol_left') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted"><?php echo lang('currencies_decimal_places') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-calculator"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" pattern="[0-9]{0,1}" name="decimal_places_currencies" id="decimal_places_currencies" required />
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted"><?php echo lang('currencies_value') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-calculator"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" pattern="\d+(\.\d{0,10})?" name="value_currencies" id="value_currencies" required />
                            </div>
                        </div>
                        <div class="mb-2 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="default_value_currencies" id="default_value_currencies" checked>
                            <label class="form-check-label" for="default_value_currencies"><?php echo lang('default_set') ?></label>
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