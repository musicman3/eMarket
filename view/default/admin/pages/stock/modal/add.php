<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>
<!-- Модальное окно "Добавить категорию" -->
<div id="add" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><a href="#" ><span data-toggle="tooltip" data-placement="left" data-original-title="Заполните карточку категорий" class="glyphicon glyphicon-question-sign"></span></a>&nbsp;&nbsp;<button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo \eMarket\Set::titlePageGenerator() ?></h4>
            </div>

            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="callAdd()">
                <div class="panel-body">
                    <input type="hidden" name="parent_id" value="<?php echo $parent_id ?>" />
                    <input type="hidden" name="add" value="ok" />
                    <input id="general_image_add" type="hidden" name="general_image_add" value="">

                    <!-- Панели формы -->
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#panel_add_1">Основное</a></li>
                        <li><a data-toggle="tab" href="#panel_add_2">Атрибуты</a></li>
                    </ul>

                    <!-- Содержимое панелей формы-->
                    <div class="tab-content">

                        <!-- Содержимое панели Основное -->
                        <div id="panel_add_1" class="tab-pane fade in active">
                            <!-- Языковые панели -->
                            <?php require_once(ROOT . '/view/' . \eMarket\Set::template() . '/layouts/lang_tabs_add.php') ?>

                            <div class="tab-content">
                                <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade in active">
                                    <div class="form-group">
                                        <div class="input-group has-error">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_categories_stock_0" id="name_categories_stock_0" required />
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if ($LANG_COUNT > 1) {
                                    for ($x = 1; $x < $LANG_COUNT; $x++) {
                                        ?>

                                        <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                            <div class="form-group">
                                                <div class="input-group has-error">
                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
                                                    <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_categories_stock_<?php echo $x ?>" id="name_categories_stock_<?php echo $x ?>" required />
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
                                <input  class="check-box" hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" type="checkbox" name="view_categories_stock" id="view_categories_stock" checked>
                                <label for="view_categories_stock"><?php echo lang('display') ?> </label>
                            </div>
                        </div>

                        <!-- Содержимое панели Атрибуты -->
                        <div id="panel_add_2" class="tab-pane fade">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th colspan="2"></th>
                                        <th>
                                            <div class="b-right"><button class="add-attribute btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-plus"></span></button></div>
                                        </th>
                                    </tr>

                                </thead>

                                <tbody class="attribute"></tbody>

                            </table>

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
<!-- КОНЕЦ Модальное окно "Добавить категорию" -->
