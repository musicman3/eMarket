<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

foreach (\eMarket\Core\View::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/privacy_policy.php')
?>

<div id="alert_block"><?php \eMarket\Core\Messages::alert(); ?></div>
<?php
if (!\eMarket\Core\Valid::inPOST('email')) {
    ?>
    <h1><?php echo lang('register_account') ?></h1>

    <div id="register" class="contentText">
        <form enctype="multipart/form-data" method="post" action="" onchange="validate()">
            <div class="row">
                <div class="col-sm-6">
                    <fieldset id="account">
                        <legend><?php echo lang('register_personal_details') ?></legend>
                        <div class="input-group has-error firstname">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input class="form-control" type="text" placeholder="<?php echo lang('register_first_name') ?>" minlength="1" id="input-firstname" value="" name="firstname" required>
                        </div>
                        <br>
                        <div class="input-group has-error lastname">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input class="form-control" type="text" placeholder="<?php echo lang('register_last_name') ?>" minlength="1" id="input-lastname" value="" name="lastname" required>
                        </div>
                        <br>
                        <div class="input-group has-error email">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                            <input class="form-control" type="email" placeholder="<?php echo lang('register_e_mail') ?>" id="input-email" value="" name="email" required>
                        </div>
                        <br>
                        <div class="input-group has-success">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
                            <input class="form-control" type="tel" placeholder="<?php echo lang('register_telephone') ?>" id="input-telephone" value="" name="telephone">
                        </div>
                        <br>
                    </fieldset>
                </div>
                <div class="col-sm-6">
                    <fieldset>
                        <legend><?php echo lang('register_details_password') ?></legend>
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
                </div>
            </div>
            <div class="text-right form-group"><?php echo sprintf(lang('register_privacy_statement_agree'), '#privacy_policy') ?>&nbsp;
                <input type="checkbox" name="agree_privacy_policy" id="agree_privacy_policy" data-on-color="success" data-off-color="danger" data-on-text="<?php echo lang('confirm-yes-switch') ?>" data-off-text="<?php echo lang('confirm-no-switch') ?>" required>&nbsp;
                <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
            </div>
        </form>
    </div>

    <?php
}
if (\eMarket\Core\Valid::inPOST('email') && \eMarket\Catalog\Register::$user_email != NULL) {
    ?>
    <h1><?php echo lang('register_account') ?></h1>

    <div id="register" class="contentText">
        <p><?php echo lang('register_problem_message') ?></p>
        <form>
            <input hidden name="route" value="register">
            <div class="text-center form-group">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
            </div>
        </form>
    </div>
    <?php
}
if (\eMarket\Core\Valid::inPOST('email') && \eMarket\Catalog\Register::$user_email == NULL) {
    ?>
    <h1><?php echo lang('register_account') ?></h1>

    <div id="register" class="contentText">
        <p><?php echo lang('register_complete_message') ?></p>
        <form>
            <input hidden name="route" value="catalog">
            <div class="text-center form-group">
                <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
            </div>
        </form>
    </div>
<?php } ?>
