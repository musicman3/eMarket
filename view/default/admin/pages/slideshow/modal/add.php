<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить" -->
<div id="add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
		<div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Сокращенное наименование указывается любыми символами" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo lang('title_' . $SET->titleDir() . '_index') ?></h4>
            </div>
            
            <div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#russian"><img src="/view/default/admin/images/langflags/russian.png" alt="russian" title="russian" width="16" height="10"> Русский</a></li>
		</ul>
		<!-- Содержимое языковых панелей -->
		<div class="tab-content">
		    <div id="russian" class="tab-pane fade in active">
			<div class="form-group">
			    <div class="input-group has-success">
				<span class="input-group-addon"><span class="glyphicon glyphicon-globe"></span></span>
				<input class="input-sm form-control" placeholder="Адрес ссылки" type="text" name="" id="" required />
			    </div>
			</div>
			<div class="form-group">
			    <div class="input-group has-success">
				<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
				<input class="input-sm form-control" placeholder="Заголовок (?)" type="text" name="" id="" required />
			    </div>
			</div>
			<div class="form-group">
			    <div class="input-group has-success">
				<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
				<input class="input-sm form-control" placeholder="Текст (?)" type="text" name="" id="" required />
			    </div>
			</div>
		    </div>
		</div>
		
		<!-- Выводим сообщения -->
		<div id="alert_messages_add"></div>

		<!-- ЗАГРУЗКА jQuery-File-Upload -->
		<div class="form-group">
		    <span class="btn btn-primary btn-sm fileinput-button">
			<i class="glyphicon glyphicon-picture"></i><span> <?php echo lang('button_add_image') ?></span>
			<input class="input-sm form-control" id="fileupload-add" type="file" name="files[]" accept="image/jpeg,image/png,image/gif" multiple>
		    </span>
		    <div id="progress" class="progress">
			<div class="progress-bar progress-bar-warning progress-bar-striped active"></div>
		    </div>
		    <div id="logo-add" class="text-center"></div>
		</div>
	    </div>

            <div class="modal-footer">
                <button class="btn btn-primary btn-xs" type="button" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
            </div>

        </div>
    </div>
</div>
<!-- КОНЕЦ Модальное окно "Добавить" -->