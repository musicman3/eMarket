<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Settings,
};
?>

<div id="settings" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="form_settings" class="was-validated" name="form_settings" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_settings')">
                <div class="modal-body">
                    <input type="hidden" id="slideshow_pref" name="slideshow_pref" value="ok" />

                    <div class="mb-3">
                        <small class="form-text text-muted"><?php echo lang('slides_interval') ?></small>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bi-watch"></span>
                            <input class="form-control" placeholder="<?php echo lang('slides_interval_placeholder') ?>" type="text" name="show_interval" id="show_interval" required />
                        </div>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="mouse_stop" id="mouse_stop" checked>
                        <label class="form-check-label" for="mouse_stop"><?php echo lang('slides_stop_on_hover') ?></label>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="autostart" id="autostart" checked>
                        <label class="form-check-label" for="autostart"><?php echo lang('slides_auto_start') ?></label>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="cicles" id="cicles" checked>
                        <label class="form-check-label" for="cicles"><?php echo lang('slides_loop_changes') ?></label>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="indicators" id="indicators" checked>
                        <label class="form-check-label" for="indicators"><?php echo lang('slides_show_indicators') ?></label>
                    </div>
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="navigation" id="navigation" checked>
                        <label class="form-check-label" for="navigation"><?php echo lang('slides_show_navigation_buttons') ?></label>
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