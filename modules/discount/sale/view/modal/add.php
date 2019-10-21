<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<div id="add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Сокращенное наименование указывается любыми символами" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . \eMarket\Set::titleDir() . '_index') ?></h4>
            </div>
            <form id="form_add_mod" name="form_add_mod" action="javascript:void(null);" onsubmit="callAdd('form_add_mod')">
                <div class="panel-body">
                    <input type="hidden" name="add" value="ok" />

                    <!-- Языковые панели -->
                    <?php require_once(ROOT . '/view/' . \eMarket\Set::template() . '/layouts/lang_tabs_add.php') ?>

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_name') ?>" type="text" name="name_module_0" id="name_module_0" required />
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
                                            <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_name') ?>" type="text" name="name_module_<?php echo $x ?>" id="name_module_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        }
                        ?>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_sale_start_date') ?>" type="text" name="start_date" id="start_date" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_sale_end_date') ?>" type="text" name="end_date" id="end_date" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('modules_discount_sale_admin_value') ?>" type="text" name="sale_value" pattern="\d+(\.\d{0,2})?" id="sale_value" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="default_module" id="default_module" type="checkbox" checked>
                            <label for="default_module"><?php echo lang('default_set') ?> </label>
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
<!-- КОНЕЦ Модальное окно "Добавить" -->