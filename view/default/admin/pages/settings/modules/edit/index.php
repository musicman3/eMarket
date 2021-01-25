<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use \eMarket\Core\{
    Messages,
    Settings,
    Valid,
    View
};
use \eMarket\Admin\ModulesEdit;
?>

<div id="settings_modules_edit">
    <div class="card shadow-element">

        <div class="card-header">
            <div id="alert_block"><?php Messages::alert(); ?></div>
            <h3 class="card-title">
                <span class="settings_back"><button type="button" onClick='location.href = "<?php echo Settings::parentPartitionGenerator() ?>"' class="btn btn-primary btn-sm"><span class="bi-reply"></span></button></span><span class="settings_name"><?php echo Settings::titlePageGenerator() ?></span>
            </h3>
        </div>
        <div class="modal-body">
            <form id="form_edit_active" name="form_edit_active" enctype="multipart/form-data">
                <input id="edit_active" type="hidden" name="edit_active" value="<?php echo Valid::inGET('type') . '_' . Valid::inGET('name') ?>" />
                <div class="pull-right">
                    <input hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('button_on') ?>" data-off-text="<?php echo lang('button_off') ?>" name="switch_active" id="switch_active" <?php echo ModulesEdit::$switch_active ?>>
                </div>
            </form>
            <div class="float-start">
                <div class="text-left"><?php echo lang('modules_name') ?> <?php echo lang('modules_' . Valid::inGET('type') . '_' . Valid::inGET('name') . '_name') ?></div>
                <div class="text-left"><?php echo lang('modules_author') ?> <?php echo lang('modules_' . Valid::inGET('type') . '_' . Valid::inGET('name') . '_author') ?></div>
                <div class="text-left"><?php echo lang('modules_version') ?> <?php echo lang('modules_' . Valid::inGET('type') . '_' . Valid::inGET('name') . '_version') ?></div>
            </div>
            <div class="clearfix"></div></br>

            <?php require_once (View::routingModules('controller') . '/index.php'); ?>

        </div>

    </div>
</div>