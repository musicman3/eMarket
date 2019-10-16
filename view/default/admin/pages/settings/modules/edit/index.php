<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="settings_modules" class="container-fluid">
    <div class="panel panel-default">

        <div class="panel-heading">
            <!--Выводим уведомление об успешном действии-->
            <?php \eMarket\Messages::alert(); ?>
            <h3 class="panel-title">
                <div class="pull-left"><span class="settings_back"><button type="button" onClick='location.href = "?route=settings/modules&active=<?php echo \eMarket\Valid::inGET('type') ?>"' class="btn btn-primary btn-xs"><span class="back glyphicon glyphicon-share-alt"></span></button></span><span class="settings_name"><?php echo lang('modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') . '_name') ?></span></div>
                <div class="clearfix"></div>
            </h3>
        </div>

        <form id="form_edit" name="form_edit" action="javascript:void(null);" onsubmit="callEdit('?route=settings/modules&active=<?php echo \eMarket\Valid::inGET('type') ?>')" enctype="multipart/form-data">
            <div class="panel-body">
                <input id="edit" type="hidden" name="edit" value="<?php echo \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') ?>" />
                <div class="pull-right">
                    <input hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('button_on') ?>" data-off-text="<?php echo lang('button_off') ?>" name="switch" id="switch" <?php echo $switch ?>>
                </div>
                <div class="pull-left">
                    <div class="text-left"><?php echo lang('modules_name') ?> <?php echo lang('modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') . '_name') ?></div>
                    <div class="text-left"><?php echo lang('modules_author') ?> <?php echo lang('modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') . '_author') ?></div>
                    <div class="text-left"><?php echo lang('modules_version') ?> <?php echo lang('modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') . '_version') ?></div>
                </div>
                <div class="clearfix"></div></br>

                <!--Выводим данные из модуля-->
                <?php require_once (ROOT . '/modules/' . \eMarket\Valid::inGET('type') . '/' . \eMarket\Valid::inGET('name') . '/controller/admin.php'); ?>

            </div>
            <?php if ($BUTTON_FLAG == 'on') { ?>
                <div class="modal-footer">
                    <button type="button" onClick='location.href = "?route=settings/modules&active=<?php echo \eMarket\Valid::inGET('type') ?>"' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                    <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
                </div>
            <?php } ?>
        </form>

    </div>
</div>