<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
require(ROOT . '/controller/admin/pages/settings/units/modal/edit.php');
?>

<!-- Модальное окно "Изменить" -->
<div id="edit" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="tooltip-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Ставка указывается в формате: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . $SET->titleDir() . '_index') ?></h4>
            </div>
            <form id="form_edit" name="form_edit" action="javascript:void(null);" onsubmit="call_edit()">
                <div class="panel-body">
                    <input class="js_edit" type="hidden" name="edit" value="" />
                    
                    <!-- Языковые панели -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#<?php echo lang('#lang_all')[0] . $modal_id ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[0] ?>.png" alt="<?php echo lang('#lang_all')[0] ?>" title="<?php echo lang('#lang_all')[0] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[0]) ?></a></li>

                        <?php
                        if (count(lang('#lang_all')) > 1) {
                            for ($xl = 1; $xl < count(lang('#lang_all')); $xl++) {
                                ?>

                                <li><a data-toggle="tab" href="#<?php echo lang('#lang_all')[$xl] . $modal_id ?>"><img src="/view/<?php echo $SET->template() ?>/admin/images/langflags/<?php echo lang('#lang_all')[$xl] ?>.png" alt="<?php echo lang('#lang_all')[$xl] ?>" title="<?php echo lang('#lang_all')[$xl] ?>" width="16" height="10" /> <?php echo lang('language_name', lang('#lang_all')[$xl]) ?></a></li>

                                <?php
                            }
                        }
                        ?>

                    </ul>

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] . $modal_id ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="name_edit0 input-sm form-control" type="text" name="name_edit_<?php echo $SET->titleDir() . '_' . lang('#lang_all')[0] ?>" id="name_edit<?php echo lang('#lang_all')[0] ?>" value="<?php echo $name_edit[0] ?>" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                    <input class="code_edit0 input-sm form-control" type="text" name="unit_edit<?php echo lang('#lang_all')[0] ?>" id="unit_edit<?php echo lang('#lang_all')[0] ?>" value="<?php echo $value_edit[0] ?>" />
                                </div>
                            </div>
                        </div>

                        <?php
                        if (count(lang('#lang_all')) > 1) {
                            for ($xl = 1; $xl < count(lang('#lang_all')); $xl++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$xl] . $modal_id ?>" class="tab-pane fade">
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="name_edit<?php echo $xl ?> input-sm form-control" type="text" name="name_edit_<?php echo $SET->titleDir() . '_' . lang('#lang_all')[$xl] ?>" id="name_edit<?php echo lang('#lang_all')[$xl] ?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-sort-by-order"></span></span>
                                            <input class="code_edit<?php echo $xl ?> input-sm form-control" type="text" name="unit_edit<?php echo lang('#lang_all')[$xl] ?>" id="unit_edit<?php echo lang('#lang_all')[$xl] ?>" />
                                        </div>
                                    </div>
                                </div>

                            <?php }
                        } ?>

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