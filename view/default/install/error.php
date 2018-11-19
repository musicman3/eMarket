<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<div class="container">
    <div class="row">
        <div class="panel panel-default">

            <div class="panel-heading">
                <h3 class="panel-title">
                    <div class="pull-left"><b><?php echo lang('install_panel') ?></b></div>
                    <div class="clearfix"></div>
                </h3>
            </div>
            <div class="panel-body">
                <form action='index.php' method='post' accept-charset='utf-8'>
                    <div class="alert alert-danger"><?php echo lang($message) ?></div>
                    <div class="alert alert-warning"><?php echo lang($error_message) ?></div>
                    <button class="btn btn-info btn-sm" type="submit" name="button_go_login" /><?php echo lang('button_go_login') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>