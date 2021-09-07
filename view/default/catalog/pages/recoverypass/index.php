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

<?php if (isset(\eMarket\Catalog\RecoveryPass::$customer_id) && \eMarket\Catalog\RecoveryPass::$customer_id != FALSE) { ?>
    <h1><?php echo lang('register_password_recovery') ?></h1>
    <div id="forgotpass" class="contentText">
        <form class="was-validated" enctype="multipart/form-data" method="post" action="" oninput="validate()">
            <input type="hidden" name="csrf_token" value="<?php echo Authorize::csrfToken() ?>" />
            <fieldset>
                <legend><?php echo lang('enter_a_new_password') ?></legend>
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
            <div class="text-end">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
            </div>
            <br>
        </form>
    </div>
<?php } else { ?>

    <h1><?php echo lang('this_page_is_not_available') ?></h1>

<?php }
