<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Valid,
    Settings
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
                    <input hidden name="staff_manager_id" value="<?php echo Valid::inGET('staff_manager_id') ?>">

                    <div class="pt-2">
                        <div class="mb-2">
                            <small class="form-text text-muted" for="email"><?php echo lang('staff_email') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="email" name="email" id="email" required />
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted" for="password"><?php echo lang('staff_password') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="password" id="password" autocomplete="off" required />
                                <button id="generate_password" class="btn btn-primary btn-sm bi-key" type="button" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo lang('staff_tooltip') ?>"> <?php echo lang('staff_generate_password') ?></button>
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="form-text text-muted" for="note"><?php echo lang('staff_note') ?></small>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bi-file-text"></span>
                                <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="note" id="note" />
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