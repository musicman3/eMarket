<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно -->
<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
                <div class="panel-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <!-- Языковые панели -->
                    <?php require_once(ROOT . '/view/' . \eMarket\Set::template() . '/layouts/lang_tabs_add.php') ?>

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_taxes_0" id="name_taxes_0" required />
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($LANG_COUNT > 1) {
                            for ($x = 1; $x < $LANG_COUNT; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_taxes_<?php echo $x ?>" id="name_taxes_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>

                        <div class="form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('tax_rate') ?>" type="text" pattern="\d+(\.\d{0,2})?" name="rate_taxes" id="rate_taxes" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-handle-width="70" data-on-text="ПРОЦЕНТ" data-off-text="СУММА" name="fixed" id="fixed" checked>
                            <br><small class="form-text text-muted">Процент / фиксированная сумма</small>
                        </div>
                        <div class="form-group">
                            <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-handle-width="70" data-on-text="ВКЛЮЧЕН" data-off-text="ОТДЕЛЬНО" name="tax_type" id="tax_type" checked>
                            <br><small class="form-text text-muted">Включен в стоимость / отдельно</small>
                        </div>
                        <div class="form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                                <select name="zones_id" id="zones_id" class="input-sm form-control">
                                    <option value="0">Москва</option>
                                </select>
                            </div>
                            <small class="form-text text-muted">Зона действия налога</small>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно -->