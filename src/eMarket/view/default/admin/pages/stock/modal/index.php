<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Lang,
    Settings
};
use eMarket\Admin\Stock;
?>

<div id="index" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light py-2 px-3">
                <h5 class="modal-title"><?php echo Settings::titlePageGenerator() ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="form_add" class="was-validated" name="form_add" action="javascript:void(null);" onsubmit="Ajax.callAdd()">
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
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#panel_add_1"><?php echo lang('stock_basic') ?></a></li>
                        <li><a class="nav-link" data-bs-toggle="tab" href="#panel_add_2"><?php echo lang('stock_specification') ?></a></li>
                    </ul>

                    <div class="tab-content pt-2">

                        <div id="panel_add_1" class="tab-pane fade show in active">

                            <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

                            <div class="tab-content pt-2">
                                <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade show in active">
                                    <div class="mb-3">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bi-file-text"></span>
                                            <input class="form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_categories_stock_0" id="name_categories_stock_0" required />
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (Lang::$count > 1) {
                                    for ($x = 1; $x < Lang::$count; $x++) {
                                        ?>

                                        <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                            <div class="mb-3">
                                                <div class="input-group input-group-sm">
                                                    <span class="input-group-text bi-file-text"></span>
                                                    <input class="form-control" placeholder="<?php echo lang('name') ?>" type="text" name="name_categories_stock_<?php echo $x ?>" id="name_categories_stock_<?php echo $x ?>" required />
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                }
                                ?>

                            </div>

                            <div id="alert_messages"></div>

                            <!-- File-Upload -->
                            <div class="mb-3">
                                <div><small class="form-text text-muted"><?php echo lang('button_add_image') ?> (<?php echo lang('max') ?>: <?php echo get_cfg_var('upload_max_filesize'); ?>)</small></div>
				<span class="btn btn-primary btn-sm bi-card-image fileinput-button mb-1">
				    <span><?php echo lang('button_add_image') ?></span>
				    <input class="form-control form-control-sm" id="fileupload" type="file" name="files[]" accept="image/jpeg,image/png,image/gif" multiple>
				</span>
                                <br>
                                <div id="progress" class="progress mb-3" style="height: 1.5rem;">
                                    <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"></div>
                                </div>
                                <div id="logo" class="gap-2 d-flex justify-content-center flex-wrap"></div>
                            </div>
                        </div>

                        <div id="panel_add_2" class="tab-pane fade">

                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th colspan="3"></th>
                                            <th>
                                                <div class="gap-2 d-flex justify-content-end">
                                                    <button class="add-group-attributes btn btn-primary btn-sm bi-plus" type="button"></button>
                                                </div>
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
                    <button class="btn btn-primary btn-sm bi-x-circle" type="button" data-bs-dismiss="modal"> <?php echo lang('cancel') ?></button>
                    <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
