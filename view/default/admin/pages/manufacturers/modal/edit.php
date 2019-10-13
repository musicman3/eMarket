<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
require(ROOT . '/controller/admin/pages/manufacturers/modal/edit.php');

?>

<!-- Модальное окно "Изменить" -->
<div id="edit" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Ставка указывается в формате: 10.00" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . \eMarket\Core\Set::titleDir() . '_index') ?></h4>
            </div>
            <form id="form_edit" name="form_edit" action="javascript:void(null);" onsubmit="callEdit()">
                <div class="panel-body">
                    <input id="js_edit" type="hidden" name="edit" value="" />
                    <input id="delete_image" type="hidden" name="delete_image" value="">
                    <input id="general_image_edit" type="hidden" name="general_image_edit" value="">
                    <input id="general_image_edit_new" type="hidden" name="general_image_edit_new" value="">

                    <!-- Языковые панели -->
                    <?php require_once(ROOT . '/view/' . \eMarket\Core\Set::template() . '/layouts/lang_tabs_edit.php') ?>

                    <!-- Содержимое языковых панелей -->
                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] . $modal_id ?>" class="tab-pane fade in active">
                            <div class="form-group">
                                <div class="input-group has-error">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                    <input class="input-sm form-control" type="text" name="name_manufacturers_edit_0" id="name_manufacturers_edit_0" required />
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
                                            <input class="input-sm form-control" type="text" name="name_manufacturers_edit_<?php echo $x ?>" id="name_manufacturers_edit_<?php echo $x ?>" required />
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }
                        }

                        ?>

                        <div class="form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('site') ?>" type="text" name="site_manufacturers_edit" id="site_manufacturers_edit" />
                            </div>
                        </div>
                        
                        <!-- Выводим сообщения -->
                        <div id="alert_messages_edit"></div>
                        
                        <!-- ЗАГРУЗКА jQuery-File-Upload -->
                        <div class="form-group">
                            <span class="btn btn-primary btn-sm fileinput-button">
                                <i class="glyphicon glyphicon-picture"></i><span> <?php echo lang('button_add_image') ?></span>
                                <input class="input-sm form-control" id="fileupload-edit" type="file" name="files[]" accept="image/jpeg,image/png,image/gif" multiple>
                            </span>
                            <?php echo lang('max') ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                            <br>
                            <br>
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-warning progress-bar-striped active"></div>
                            </div>
                            <div id="logo-edit" class="text-center"></div>
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