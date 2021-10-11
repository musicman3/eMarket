<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Lang,
    Settings
};
use eMarket\Admin\{
    HeaderMenu,
    StaffManager
};
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
                    <input type="hidden" id="add" name="add" value="" />
                    <input type="hidden" id="edit" name="edit" value="" />

                    <?php require_once(ROOT . '/view/' . Settings::template() . '/layouts/lang_tabs_add.php') ?>

                    <div class="tab-content pt-2">
                        <div id="<?php echo lang('#lang_all')[0] ?>" class="tab-pane fade show in active">
                            <small class="form-text text-muted" for="staff_manager_group_0"><?php echo lang('staff_manager_group') ?></small>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="staff_manager_group_0" id="staff_manager_group_0" required />
                            </div>
                            <small class="form-text text-muted" for="staff_manager_note_0"><?php echo lang('staff_manager_note') ?></small>
                            <div class="input-group input-group-sm mb-2">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="staff_manager_note_0" id="staff_manager_note_0" />
                            </div>
                        </div>

                        <?php
                        if (Lang::$count > 1) {
                            for ($x = 1; $x < Lang::$count; $x++) {
                                ?>

                                <div id="<?php echo lang('#lang_all')[$x] ?>" class="tab-pane fade">
                                    <small class="form-text text-muted" for="staff_manager_group_<?php echo $x ?>"><?php echo lang('staff_manager_group') ?></small>
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text bi-file-text"></span>
                                        <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="staff_manager_group_<?php echo $x ?>" id="staff_manager_group_<?php echo $x ?>" required />
                                    </div>
                                    <small class="form-text text-muted" for="staff_manager_note_<?php echo $x ?>"><?php echo lang('staff_manager_note') ?></small>
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text bi-file-text"></span>
                                        <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="staff_manager_note_<?php echo $x ?>" id="staff_manager_note_<?php echo $x ?>" />
                                    </div>
                                </div>

                                <?php
                            }
                        }
                        ?>
                        <div class="input-group input-group-sm mb-2">
                            <small class="form-text text-muted" for="staff_manager_note_<?php echo $x ?>"><?php echo lang('staff_manager_permissions') ?></small>
                            <span class="multiselect-native-select me-auto">
                                <select id="permissions" name="permissions[]" multiple="multiple">
                                    <?php foreach (HeaderMenu::$level as $level_key => $level) { ?>
                                        <optgroup class="multiselect-add" label="<?php echo $level[1] ?>">
                                            <?php
                                            if (isset(HeaderMenu::$menu[$level_key])) {
                                                foreach (HeaderMenu::$menu[$level_key] as $level_value) {
                                                    ?>
                                                    <option id="<?php echo 'hash_' . md5($level_value[0]) ?>" value="<?php echo $level_value[0] ?>" <?php echo StaffManager::permissionClass($level_value[0]) ?>><?php echo $level_value[2] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </optgroup>
                                    <?php } ?>
                                </select>
                            </span>

                        </div>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="demo_mode" id="demo_mode">
                            <label class="form-check-label" for="demo_mode"><?php echo lang('staff_manager_mode') ?></label>
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