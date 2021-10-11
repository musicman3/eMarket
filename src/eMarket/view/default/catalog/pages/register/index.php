<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Messages,
    Valid,
    View
};
use eMarket\Catalog\Register;

foreach (View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/privacy_policy.php')
?>

<div id="alert_block"><?php Messages::alert(); ?></div>
<?php
if (!Valid::inPOST('email')) {
    ?>
    <h1><?php echo lang('register_account') ?></h1>

    <div id="register" class="contentText">
        <form class="was-validated" enctype="multipart/form-data" method="post" action="" oninput="validate()">
            <input type="hidden" name="csrf_token" value="<?php echo Authorize::csrfToken() ?>" />
            <div class="row">
                <div class="col-md-6">
                    <fieldset id="account">
                        <legend><?php echo lang('register_personal_details') ?></legend>
                        <div class="input-group firstname">
                            <span class="input-group-text bi-person"></span>
                            <input class="form-control" type="text" placeholder="<?php echo lang('register_first_name') ?>" minlength="1" id="input-firstname" value="" name="firstname" required>
                        </div>
                        <br>
                        <div class="input-group lastname">
                            <span class="input-group-text bi-person"></span>
                            <input class="form-control" type="text" placeholder="<?php echo lang('register_last_name') ?>" minlength="1" id="input-lastname" value="" name="lastname" required>
                        </div>
                        <br>
                        <div class="input-group email">
                            <span class="input-group-text bi-envelope"></span>
                            <input class="form-control" type="email" placeholder="<?php echo lang('register_e_mail') ?>" id="input-email" value="" name="email" required>
                        </div>
                        <br>
                        <div class="input-group">
                            <span class="input-group-text bi-telephone"></span>
                            <input class="form-control" placeholder="<?php echo lang('register_telephone') ?>" type="tel" pattern="(\+[0-9]{10,13})" id="input-telephone" value="" name="telephone">
                        </div>
                        <br>
                    </fieldset>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <legend><?php echo lang('register_details_password') ?></legend>
                        <div class="input-group password">
                            <span class="input-group-text bi-lock"></span>
                            <input class="form-control" type="password" minlength="7" maxlength="40" placeholder="<?php echo lang('password') ?>" id="input-password" value="" name="password" required>
                        </div>
                        <br>
                        <div class="input-group confirm">
                            <span class="input-group-text bi-lock"></span>
                            <input class="form-control" type="password" minlength="7" maxlength="40" placeholder="<?php echo lang('confirm_password') ?>" id="input-confirm" value="" name="confirm" required>
                        </div>
                        <br>
                    </fieldset>
                </div>
            </div>
        
            <div class="text-end mb-3 form-switch">
                <?php echo sprintf(lang('register_privacy_statement_agree'), '#privacy_policy') ?>&nbsp;
                <input class="form-check-input" type="checkbox" name="agree_privacy_policy" id="agree_privacy_policy" required>&nbsp;
                <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
            </div>
        </form>
    </div>

    <?php
}
if (Valid::inPOST('email') && Register::$user_email != NULL) {
    ?>
    <h1><?php echo lang('register_account') ?></h1>

    <div id="register" class="contentText">
        <div class="bg-light border rounded mb-3 py-3 px-2">
            <p class="card-text"><?php echo lang('register_problem_message') ?></p>
        </div>
        <form>
            <input hidden name="route" value="register">
            <div class="text-end">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
            </div>
        </form>
    </div>
    <?php
}
if (Valid::inPOST('email') && Register::$user_email == NULL) {
    ?>
    <h1><?php echo lang('register_account') ?></h1>

    <div id="register" class="contentText">
        <div class="bg-light border rounded mb-3 py-3 px-2">
            <p class="card-text"><?php echo lang('register_complete_message') ?></p>
        </div>
        <form>
            <input hidden name="route" value="catalog">
            <div class="text-end">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
            </div>
        </form>
    </div>
<?php
}
