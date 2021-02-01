<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Settings,
};
use \eMarket\Admin\Slideshow;
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="form_add" class="was-validated" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd(null, null, '<?php echo lang('alert_wait') ?>')">
                <div class="modal-body">
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />
                    <input type="hidden" id="set_language" name="set_language" value="<?php echo Slideshow::$set_language ?>" />
                    <input id="general_image_add" type="hidden" name="general_image_add" value="">
                    <input id="delete_image" type="hidden" name="delete_image" value="">
                    <input id="general_image_edit" type="hidden" name="general_image_edit" value="">
                    <input id="general_image_edit_new" type="hidden" name="general_image_edit_new" value="">

                    <div class="mb-2">
                        <small class="form-text text-muted"><?php echo lang('slides_name') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><span class="bi-file-text"></span></span>
                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="name" id="name" />
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="form-text text-muted"><?php echo lang('slides_text') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><span class="bi-file-text"></span></span>
                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="heading" id="heading" />
                        </div>
                    </div>
                    <div class="mb-2 row align-items-center">
                        <div class="col-md-6">
			    <div class="form-check form-switch">
				<input class="form-check-input" type="checkbox" name="animation" id="animation" checked>
				<label class="form-check-label" for="animation"><?php echo lang('slides_text_animation') ?></label>
			    </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm justify-content-end">
                                <label class="input-group-text" for="color"> <?php echo lang('slides_text_color') ?></label>
                                <input type="color" class="form-control form-control-color" name="color" id="color" value="#ffffff" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="form-text text-muted"><?php echo lang('slides_url') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><span class="bi-globe"></span></span>
                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="url" id="url" />
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="form-text text-muted"><?php echo lang('slides_show_start') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><span class="bi-calendar3"></span></span>
                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="start_date" id="start_date" autocomplete="off" required />
                        </div>
                    </div>
                    <div class="mb-2">
                        <small class="form-text text-muted"><?php echo lang('slides_show_end') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text"><span class="bi-calendar3"></span></span>
                            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="end_date" id="end_date" autocomplete="off" required />
                        </div>
                    </div>

                    <div id="alert_messages"></div>

                    <!-- jQuery-File-Upload -->
                    <div class="mb-2">
                        <span class="btn btn-primary btn-sm fileinput-button">
                            <span class="bi-image"></span><span> <?php echo lang('button_add_image') ?></span>
                            <input class="input-sm form-control" id="fileupload" type="file" name="files[]" accept="image/jpeg,image/png,image/gif" multiple>
                        </span>
                        <?php echo lang('max') ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                        <br>
                        <br>
                        <div id="progress" class="progress">
                            <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"></div>
                        </div>
                        <div id="logo" class="gap-2 d-flex justify-content-center flex-wrap"></div>
                    </div>

                    <div class="mb-2 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="view_slideshow" id="view_slideshow" checked>
                        <label class="form-check-label" for="view_slideshow"><?php echo lang('display') ?></label>
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