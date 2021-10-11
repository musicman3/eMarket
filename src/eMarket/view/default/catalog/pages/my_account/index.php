<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Messages,
    View
};

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
?>

<div id="alert_block"><?php Messages::alert(); ?></div>
<h1><?php echo lang('my_account_name') ?></h1>

<div id="my_account" class="contentText">
    <form class="was-validated" name="form_add" id="form_add" action="javascript:void(null);" oninput="validate()" onsubmit="Ajax.callAdd()">
        <input type="hidden" id="edit" name="edit" value="ok" />
        <div class="row">

            <div class="col-md-6">
                <div class="mb-3">
                    <legend><?php echo lang('my_account_personal_details') ?></legend>
                    <small class="form-text text-muted"><?php echo lang('my_account_firstname') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control" placeholder="<?php echo lang('my_account_enter_your_firstname') ?>" type="text" name="firstname" id="firstname" value="<?php echo Authorize::$customer['firstname'] ?>" required />
                    </div>

                    <small class="form-text text-muted"><?php echo lang('my_account_lastname') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control" placeholder="<?php echo lang('my_account_enter_your_lastname') ?>" type="text" name="lastname" id="lastname" value="<?php echo Authorize::$customer['lastname'] ?>" required />
                    </div>

                    <small class="form-text text-muted"><?php echo lang('my_account_middlename') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control" placeholder="<?php echo lang('my_account_enter_your_middlename') ?>" type="text" name="middle_name" id="middle_name" value="<?php echo Authorize::$customer['middle_name'] ?>" />
                    </div>

                    <small class="form-text text-muted"><?php echo lang('my_account_telephone') ?></small>
                    <div class="input-group">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control" placeholder="<?php echo lang('my_account_enter_your_phone') ?>" type="tel" pattern="(\+[0-9]{10,13})" name="telephone" id="lastname" value="<?php echo Authorize::$customer['telephone'] ?>" />
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <legend><?php echo lang('my_account_details_password') ?></legend>
                    <small class="form-text text-muted"><?php echo lang('my_account_password') ?></small>
                    <div class="input-group password">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control password-data" minlength="7" maxlength="40" placeholder="<?php echo lang('my_account_enter_your_password') ?>" type="password" name="password" id="password" />
                    </div>

                    <small class="form-text text-muted"><?php echo lang('my_account_confirm_password') ?></small>
                    <div class="input-group confirm">
                        <span class="input-group-text bi-pencil"></span>
                        <input class="form-control password-data" minlength="7" maxlength="40" placeholder="<?php echo lang('my_account_confirm_your_password') ?>" type="password" name="confirm_password" id="confirm_password" />
                    </div>
                </div>
            </div>

        </div>

        <div class="text-end mb-3">
            <input id="submit_btn" class="btn btn-primary" type="submit" value="<?php echo lang('save') ?>">
        </div>

    </form>
</div>
