<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Authorize,
    Messages,
    Routing
};

foreach (Routing::tlpc('content') as $path) {
    require_once (ROOT . $path);
}
require_once('modal/recovery_password.php')
?>

<div id="alert_block"><?php Messages::alert(); ?></div>
<h1><?php echo lang('login_to_account') ?></h1>

<div id="login" class="contentText">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form class="was-validated" enctype="multipart/form-data" method="post" action="">
                        <input type="hidden" name="csrf_token" value="<?php echo Authorize::csrfToken() ?>" />
                        <legend><?php echo lang('regular_customer') ?></legend>
                        <div class="mb-3 email">
                            <input class="form-control" type="email" placeholder="<?php echo lang('login_e_mail') ?>" id="email" name="email" required>
                        </div>
                        <div class="mb-3 password">
                            <input class="form-control" type="password" minlength="7" maxlength="40" placeholder="<?php echo lang('login_password') ?>" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary w-100" type="submit"><?php echo lang('login_sign_in') ?></button>
                        </div>
                    </form>
                    <a class="btn btn-outline-secondary" href="#forgot_password" data-bs-toggle="modal"><?php echo lang('login_forgot_your_password') ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <legend><?php echo lang('login_new_customer') ?></legend>
                    <p><?php echo lang('login_description') ?></p>
                    <a href="/?route=register" class="btn btn-success w-100"><?php echo lang('login_register') ?></a>
                    <p></p>
                    <a href="/?route=without_registration" class="btn btn-outline-danger w-100"><?php echo lang('login_buy_without_registration') ?></a>
                </div>
            </div>
        </div>
    </div>
</div>