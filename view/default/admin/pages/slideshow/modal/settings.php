<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
require(ROOT . '/controller/admin/pages/slideshow/modal/settings.php');

?>
<!-- Модальное окно "Настройки" -->
<div id="settings" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку слайдов" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . $SET->titleDir() . '_index') ?></h4>
            </div>

                <div class="panel-body">

                    <!-- Выводим сообщения -->
                    <div id="alert_messages_settings"></div>
                    
		    <div class="form-group has-error">
			<input class="input-sm form-control" placeholder="Интервал (мс)" type="text" name="" id="" required />
		    </div>
		    <div class="form-group">
			<label>Остановка слайдшоу при нахождении курсора </label>
			<input class="check-box" type="checkbox" checked="">
		    </div>
		    <div class="form-group">
			<label>Запуск слайдшоу автоматически </label>
			<input class="check-box" type="checkbox" checked="">
		    </div>
		    <div class="form-group">
			<label>Зацикливать смену слайдов </label>
			<input class="check-box" type="checkbox" checked="">
		    </div>
		    <div class="form-group">
			<label>Показывать индикаторы </label>
			<input class="check-box" type="checkbox" checked="">
		    </div>
		    <div class="form-group">
			<label>Показывать стрелки навигации </label>
			<input class="check-box" type="checkbox" checked="">
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