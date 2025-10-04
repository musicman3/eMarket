<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\Messages;
?>

<div id="login" class="row">


    <div id="alert_block"><?php Messages::alert(); ?></div>


    <div class="position-absolute top-50 start-50 translate-middle d-flex h-25 lbox-horz"></div>
    <div class="login_logo p-5"><?php echo lang('shop_name') ?></div>

    <div class="d-flex justify-content-end col-11">
        <div class="d-flex h-100 align-items-center lbox-vert p-3">
            <div class="p-2">
                <div class="row h-50"></div>
                <form action='?route=login' method='post' class="was-validated">

                    <input hidden name="authorize" value="ok">

                    <div class="mb-3">
                        <input type="text" name="login" class="input-sm form-control" placeholder="<?php echo lang('email') ?>" required />
                    </div>
                    <div class="mb-3">
                        <input type="password" name="pass" class="input-sm form-control" placeholder="<?php echo lang('password') ?>" required />
                    </div>

                    <input type="submit" class="btn w-100 btn-sm btn-light" value="<?php echo lang('entrance') ?>" />
                </form>
            </div>
        </div>
    </div>
</div>
