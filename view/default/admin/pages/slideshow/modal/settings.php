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
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>
            
            <form id="form_settings" name="form_settings" action="javascript:void(null);" onsubmit="callAdd('form_settings')">
                <div class="panel-body">

                    <div class="form-group">
                        <small class="form-text text-muted">Интервал (мс)</small>
                        <div class="input-group has-error">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                            <input class="input-sm form-control" placeholder="Интервал (мс)" type="text" name="show_interval" id="show_interval" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" id="mouse_stop">
                        <label>Остановка слайдшоу при нахождении курсора </label>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" id="autostart">
                        <label>Запуск слайдшоу автоматически </label>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" id="cicles">
                        <label>Зацикливать смену слайдов </label>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" id="indicators">
                        <label>Показывать индикаторы </label>
                    </div>
                    <div class="form-group">
                        <input class="check-box" type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" id="navigation">
                        <label>Показывать стрелки навигации </label>
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