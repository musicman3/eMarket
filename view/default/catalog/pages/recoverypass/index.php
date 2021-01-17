<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

foreach (\eMarket\Core\View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
?>

<div id="alert_block"><?php \eMarket\Core\Messages::alert(); ?></div>

<?php if (isset(\Market\Catalog\RecoveryPass::$customer_id) && \Market\Catalog\RecoveryPass::$customer_id != FALSE) { ?>
    <h1><?php echo lang('register_password_recovery') ?></h1>
    <div id="forgotpass" class="contentText">
        <form enctype="multipart/form-data" method="post" action="" onchange="validate()">
            <fieldset>
                <legend><?php echo lang('enter_a_new_password') ?></legend>
                <div class="input-group has-error password">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input class="form-control" type="password" minlength="7" maxlength="40" placeholder="<?php echo lang('password') ?>" id="input-password" value="" name="password" required>
                </div>
                <br>
                <div class="input-group has-error confirm">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input class="form-control" type="password" minlength="7" maxlength="40" placeholder="<?php echo lang('confirm_password') ?>" id="input-confirm" value="" name="confirm" required>
                </div>
                <br>
            </fieldset>
            <div class="text-right">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
            </div>
            <br>
        </form>
    </div>
<?php } else { ?>

    <h1><?php echo lang('this_page_is_not_available') ?></h1>

<?php } ?>
