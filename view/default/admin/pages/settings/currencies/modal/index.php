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
                                    <input class="input-sm form-control" placeholder="<?php echo lang('name_full') ?>" type="text" name="name_currencies_0" id="name_currencies_0" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="input-group has-error">
                                    <span class="input-group-text"><span class="bi-pen"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('name_little') ?>" type="text" name="code_currencies_0" id="code_currencies_0" required />
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
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name_full') ?>" type="text" name="name_currencies_<?php echo $x ?>" id="name_currencies_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group has-error">
                                            <span class="input-group-text"><span class="bi-pen"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name_little') ?>" type="text" name="code_currencies_<?php echo $x ?>" id="code_currencies_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        <div class="mb-3">
                            <div class="input-group has-error">
                                <span class="input-group-text"><span class="bi-pen"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('iso_4217') ?>" type="text" pattern="[A-Za-z]{3}" name="iso_4217_currencies" id="iso_4217_currencies" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group has-success">
                                <span class="input-group-text"><span class="bi-pen"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('currency_symbol') ?>" type="text" name="symbol_currencies" id="symbol_currencies" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group has-success">
                                <span class="input-group-text"><span class="bi-pen"></span></span>
                                <select name="symbol_position_currencies" id="symbol_position_currencies" class="input-sm form-control">
                                    <option value="right"><?php echo lang('symbol_right') ?></option>
                                    <option value="left" selected><?php echo lang('symbol_left') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group has-error">
                                <span class="input-group-text"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('decimal_places') ?>" type="text" pattern="[0-9]{0,1}" name="decimal_places_currencies" id="decimal_places_currencies" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="input-group has-error">
                                <span class="input-group-text"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('value') ?>" type="text" pattern="\d+(\.\d{0,10})?" name="value_currencies" id="value_currencies" required />
                            </div>
                        </div>
                        <div class="mb-3">
                            <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="default_value_currencies" id="default_value_currencies" checked>
                            <label for="default_value_currencies"><?php echo lang('default_set') ?> </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="button" data-dismiss="modal"><span class="bi-x-circle"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-sm"><span class="bi-check-circle"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>