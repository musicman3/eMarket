<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Settings::titlePageGenerator() ?></h4>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd(null, null, '<?php echo lang('alert_wait') ?>')">
                <div class="panel-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />
                    <input type="hidden" id="set_language" name="set_language" value="<?php echo \eMarket\Admin\Slideshow::$set_language ?>" />
                    <input id="general_image_add" type="hidden" name="general_image_add" value="">
                    <input id="delete_image" type="hidden" name="delete_image" value="">
                    <input id="general_image_edit" type="hidden" name="general_image_edit" value="">
                    <input id="general_image_edit_new" type="hidden" name="general_image_edit_new" value="">

                        <div class="form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('slides_name') ?>" type="text" name="name" id="name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('slides_text') ?>" type="text" name="heading" id="heading" />
                            </div>
                        </div>
                        <div class="form-group row">
			    <div class="col-xs-6">
				<div class="input-group">
				    <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="animation" id="animation" checked>
				    <label for="animation"> <?php echo lang('slides_text_animation') ?></label>
				</div>
			    </div>
			    <div class="col-xs-6 slide-color">
				<div class="input-group">
                                    <input type="color" name="color" id="color" value="#ffffff" />
				    <label for="color"> <?php echo lang('slides_text_color') ?></label>
				</div>
			    </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group has-success">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('slides_url') ?>" type="text" name="url" id="url" />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('slides_show_start') ?>" type="text" name="start_date" id="start_date" autocomplete="off" required />
                            </div>
                        </div>
                        <div class="col-left form-group">
                            <div class="input-group has-error">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                <input class="input-sm form-control" placeholder="<?php echo lang('slides_show_end') ?>" type="text" name="end_date" id="end_date" autocomplete="off" required />
                            </div>
                        </div>

                    <!-- Выводим сообщения -->
                    <div id="alert_messages"></div>

                    <!-- ЗАГРУЗКА jQuery-File-Upload -->
                    <div class="form-group">
                        <span class="btn btn-primary btn-sm fileinput-button">
                            <span class="glyphicon glyphicon-picture"></span><span> <?php echo lang('button_add_image') ?></span>
                            <input class="input-sm form-control" id="fileupload" type="file" name="files[]" accept="image/jpeg,image/png,image/gif" multiple>
                        </span>
                        <?php echo lang('max') ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                        <br>
                        <br>
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-warning progress-bar-striped active"></div>
                        </div>
                        <div id="logo" class="text-center"></div>
                    </div>

                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="view_slideshow" id="view_slideshow" checked>
                        <label for="view_slideshow"><?php echo lang('display') ?> </label>
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