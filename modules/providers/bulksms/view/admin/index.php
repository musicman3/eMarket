<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\Modules\Providers\Bulksms;
?>

<form class="was-validated" id="form_add_mod" name="form_add_mod" action="javascript:void(null);" onsubmit="Ajax.callAdd('form_add_mod')">

    <input type="hidden" name="save" value="ok" />

    <div class="mb-3">
        <small class="form-text text-muted"><?php echo lang('modules_providers_bulksms_admin_sender') ?></small>
        <div class="input-group sender">
            <span class="input-group-text bi-pencil"></span>
            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="sender" id="sender" value="<?php echo Bulksms::$data['sender'] ?>" required />
        </div>
        
        <small class="form-text text-muted"><?php echo lang('modules_providers_bulksms_admin_login') ?></small>
        <div class="input-group login">
            <span class="input-group-text bi-pencil"></span>
            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="text" name="login" id="login" value="<?php echo Bulksms::$data['login'] ?>" required />
        </div>

        <small class="form-text text-muted"><?php echo lang('modules_providers_bulksms_admin_password') ?></small>
        <div class="input-group password">
            <span class="input-group-text bi-pencil"></span>
            <input class="form-control" placeholder="<?php echo lang('enter_value') ?>" type="password" name="password" id="password" value="<?php echo Bulksms::$data['password'] ?>" required />
        </div>
    </div>

    <div class="text-start">
        <button class="btn btn-primary btn-sm bi-check-circle" type="submit"> <?php echo lang('save') ?></button>
    </div>

</form>

