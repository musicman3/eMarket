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
            <div class="modal-header">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="form_add" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
                <div class="modal-body">
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
                        <li class="active"><a data-bs-toggle="tab" href="#panel_add_1"><?php echo lang('stock_basic') ?></a></li>
                        <li><a data-bs-toggle="tab" href="#panel_add_2"><?php echo lang('stock_specification') ?></a></li>
                    </ul>

                    <div class="tab-content">

                        <div id="panel_add_1" class="tab-pane fade show in active">

                            <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

                            <div class="tab-content">
                                <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade show in active">
                                    <div class="mb-3">
                                        <div class="input-group has-error">
                                            <span class="input-group-text"><span class="bi-file-text"></span></span>
                                            <input class="input-sm form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_categories_stock_0" id="name_categories_stock_0" required />
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (Lang::$count > 1) {
                                    for ($x = 1; $x < Lang::$count; $x++) {
                                        ?>

                                        <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                            <div class="mb-3">
                                                <div class="input-group has-error">
                                                    <span class="input-group-text"><span class="bi-file-text"></span></span>
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
                            <div class="mb-3">
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
                                                <div class="flexbox"><button class="add-group-attributes btn btn-primary btn-sm" type="button"><span class="bi-plus"></span></button></div>
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
                    <button class="btn btn-primary btn-sm" type="button" data-dismiss="modal"><span class="bi-x-circle"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-sm"><span class="bi-check-circle"></span> <?php echo lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
