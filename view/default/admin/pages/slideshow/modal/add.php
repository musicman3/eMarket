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
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>
            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="callAdd()">
                <div class="panel-body">

                    <!-- Языковые панели -->
                    <?php require_once(ROOT . '/view/' . \eMarket\Set::template() . '/layouts/lang_tabs_add.php') ?>

                    <div class="tab-content">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
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
                        <?php
                        if ($LANG_COUNT > 1) {
                            for ($x = 1; $x < $LANG_COUNT; $x++) {

                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
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

                                <?php
                            }
                        }

                        ?>
                    </div>
                    
                    <!-- Выводим сообщения -->
                    <div id="alert_messages_add"></div>

                    <!-- ЗАГРУЗКА jQuery-File-Upload -->
                    <div class="form-group">
                        <span class="btn btn-primary btn-sm fileinput-button">
                            <i class="glyphicon glyphicon-picture"></i><span> <?php echo lang('button_add_image') ?></span>
                            <input class="input-sm form-control" id="fileupload-add" type="file" name="files[]" accept="image/jpeg,image/png,image/gif" multiple>
                        </span>
                        <?php echo lang('max') ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>
                        <br>
                        <br>
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-warning progress-bar-striped active"></div>
                        </div>
                        <div id="logo-add" class="text-center"></div>
                    </div>
                    <div class="form-group">
                        <label for="view_slideshow"><?php echo lang('display') ?> </label>
                        <input class="check-box" type="checkbox" name="view_slideshow" id="view_slideshow" checked>
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