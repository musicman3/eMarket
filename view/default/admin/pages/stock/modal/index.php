<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Lang,
    Settings
};
use \eMarket\Admin\Stock;
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><div class="pull-right"><button class="close" type="button" data-dismiss="modal">×</button></div>
                <h4 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h4>
            </div>

            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
                <div class="panel-body">
                    <input type="hidden" name="parent_id" value="<?php echo Stock::$parent_id ?>" />
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />
                    <input id="general_image_add" type="hidden" name="general_image_add" value="">
                    <input id="delete_image" type="hidden" name="delete_image" value="">
                    <input id="general_image_edit" type="hidden" name="general_image_edit" value="">
                    <input id="general_image_edit_new" type="hidden" name="general_image_edit_new" value="">
                    <input id="attributes" type="hidden" name="attributes" value="">
                    <input id="group_attributes" type="hidden" name="group_attributes" value="">

                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#panel_add_1"><?php echo lang('stock_basic') ?></a></li>
                        <li><a data-toggle="tab" href="#panel_add_2"><?php echo lang('stock_specification') ?></a></li>
                    </ul>

                    <div class="tab-content">

                        <div id="panel_add_1" class="tab-pane fade in active">

                            <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

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
                                if (Lang::$COUNT > 1) {
                                    for ($x = 1; $x < Lang::$COUNT; $x++) {
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

                            <div id="alert_messages"></div>

                            <!-- jQuery-File-Upload -->
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
                        </div>

                        <div id="panel_add_2" class="tab-pane fade">

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th>
                                                <div class="flexbox"><button class="add-group-attributes btn btn-primary btn-xs" type="button"><span class="glyphicon glyphicon-plus"></span></button></div>
                                            </th>
                                        </tr>

                                    </thead>

                                    <tbody class="group-attributes"></tbody>

                                </table>
                            </div>

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
