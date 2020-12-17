<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Настройки" -->
<div id="settings" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Settings::titlePageGenerator() ?></h4>
            </div>
            
            <form id="form_settings" name="form_settings" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_settings')">
                <div class="panel-body">
                    <input type="hidden" id="slideshow_pref" name="slideshow_pref" value="ok" />

                    <div class="form-group">
                        <small class="form-text text-muted"><?php echo lang('slides_interval') ?></small>
                        <div class="input-group has-error">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                            <input class="input-sm form-control" placeholder="<?php echo lang('slides_interval_placeholder') ?>" type="text" name="show_interval" id="show_interval" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="mouse_stop" id="mouse_stop">
                        <label><?php echo lang('slides_stop_on_hover') ?> </label>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="autostart" id="autostart">
                        <label><?php echo lang('slides_auto_start') ?> </label>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="cicles" id="cicles">
                        <label><?php echo lang('slides_loop_changes') ?> </label>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="indicators" id="indicators">
                        <label><?php echo lang('slides_show_indicators') ?> </label>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" name="navigation" id="navigation">
                        <label><?php echo lang('slides_show_navigation_buttons') ?> </label>
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
<!-- КОНЕЦ Модальное окно "Настройки" -->