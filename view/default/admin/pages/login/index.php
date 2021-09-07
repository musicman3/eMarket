<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\Messages;
?>

<div id="login" class="row">
    <div class="lbox-horz"></div>
    <div class="lbox-vert"></div>
<div id="alert_block"><?php Messages::alert(); ?></div>
    <div class="login_logo">eMarket</div>


    <div class="login-box side-form">
        <form action='?route=login' method='post' class="was-validated">

            <input hidden name="authorize" value="ok">

            <div class="mb-3">
                <input type="text" name="login" class="input-sm form-control" placeholder="<?php echo lang('email') ?>" required />
            </div>
            <div class="mb-3">
                <input type="password" name="pass" class="input-sm form-control" placeholder="<?php echo lang('password') ?>" required />
            </div>

            <input type="submit" class="btn w-100 btn-sm" value="<?php echo lang('entrance') ?>" />
        </form>
    </div>
</div>
