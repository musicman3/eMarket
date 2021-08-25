<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Valid
};
use eMarket\Install\Error;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-white bg-danger">
            <h5 class="card-title"><?php echo lang('install_panel') ?></h5>
        </div>
        <div class="card-body">
            <form action='index.php' method='post' accept-charset='utf-8'>
                <div class="alert alert-danger"><?php echo lang(Error::$message) ?></div>

                <?php if (Valid::inGET('error_message')) { ?>
                    <div class="alert alert-warning"><?php echo Error::$error_message ?></div>
                <?php } ?>

                <button class="btn btn-primary" type="submit" name="button_go_login" /><?php echo lang('button_go_login') ?></button>
            </form>
        </div>
    </div>
</div>