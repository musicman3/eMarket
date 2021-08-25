<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header text-white bg-success">
            <h5 class="card-title"><?php echo lang('install_panel') ?></h5>
        </div>
        <div class="card-body">
            <form action='/controller/admin/?route=login' method='post' accept-charset='utf-8'>
                <input type="hidden" name="install" value="ok" />
                <div class="alert alert-success"><?php echo lang('success') ?></div>
                <input type="hidden" name="language" value="<?php echo \eMarket\Install\Success::$lng ?>" />
                <button class="btn btn-primary" type="submit" name="button_go_login" /><?php echo lang('button_go_login') ?></button>
            </form>
        </div>
    </div>
</div>