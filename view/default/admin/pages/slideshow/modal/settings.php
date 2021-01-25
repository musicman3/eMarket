<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Settings,
};
?>

<div id="settings" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="form_settings" name="form_settings" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_settings')">
                <div class="modal-body">
                    <input type="hidden" id="slideshow_pref" name="slideshow_pref" value="ok" />

                    <div class="mb-3">
                        <small class="form-text text-muted"><?php echo lang('slides_interval') ?></small>
                        <div class="input-group has-error">
                            <span class="input-group-text"><span class="glyphicon glyphicon-time"></span></span>
                            <input class="input-sm form-control" placeholder="<?php echo lang('slides_interval_placeholder') ?>" type="text" name="show_interval" id="show_interval" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="mouse_stop" id="mouse_stop">
                        <label><?php echo lang('slides_stop_on_hover') ?> </label>
                    </div>
                    <div class="mb-3">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="autostart" id="autostart">
                        <label><?php echo lang('slides_auto_start') ?> </label>
                    </div>
                    <div class="mb-3">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="cicles" id="cicles">
                        <label><?php echo lang('slides_loop_changes') ?> </label>
                    </div>
                    <div class="mb-3">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="indicators" id="indicators">
                        <label><?php echo lang('slides_show_indicators') ?> </label>
                    </div>
                    <div class="mb-3">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="navigation" id="navigation">
                        <label><?php echo lang('slides_show_navigation_buttons') ?> </label>
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