<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

require(ROOT . '/controller/admin/pages/settings/vendor_codes/modal/edit.php');

?>

<!-- Модальное окно "Изменить" -->
<div id="edit" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Ставка указывается в формате: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . \eMarket\Set::titleDir() . '_index') ?></h4>
            </div>
            <form id="form_edit" name="form_edit" action="javascript:void(null);" onsubmit="callEdit()">
                <div class="panel-body">
                    <input id="js_edit" type="hidden" name="edit" value="" />

                    <!-- Языковые панели -->
                    <?php require_once(ROOT . '/view/' . \eMarket\Set::template() . '/layouts/lang_tabs_edit.php') ?>

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] . $modal_id ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" type="text" name="name_vendor_codes_edit_0" id="name_vendor_codes_edit_0" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group has-success">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                    <input class="input-sm form-control" placeholder="<?php echo lang('name_description') ?>" type="text" name="vendor_code_edit_0" id="vendor_code_edit_0" />
                                </div>
                            </div>
                        </div>

                        <?php
                        if ($LANG_COUNT > 1) {
                            for ($x = 1; $x < $LANG_COUNT; $x++) {

                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] . $modal_id ?>" class="tab-pane fade">
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" type="text" name="name_vendor_codes_edit_<?php echo $x ?>" id="name_vendor_codes_edit_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group has-success">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name_description') ?>" type="text" name="vendor_code_edit_<?php echo $x ?>" id="vendor_code_edit_<?php echo $x ?>" />
                                        </div>
                                    </div>
                                </div>

                            <?php
                            }
                        }

                        ?>
                        <div class="form-group">
                            <input class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="default_vendor_code_edit" id="default_vendor_code_edit" type="checkbox" checked>
                            <label for="default_vendor_code_edit"><?php echo lang('default_set') ?> </label>
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
<!-- КОНЕЦ Модальное окно "Изменить" -->