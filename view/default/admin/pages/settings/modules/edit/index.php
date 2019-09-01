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
            <?php $MESSAGES->alert(); ?>
            <h3 class="panel-title">
                <div class="pull-left"><a class="btn btn-primary btn-xs" href="?route=settings/modules&active=<?php echo $VALID->inGET('type') ?>"><span class="back glyphicon glyphicon-share-alt"></span></a> <?php echo lang($VALID->inGET('type') . '_' . $VALID->inGET('name') . '_name') ?></div>
                <div class="clearfix"></div>
            </h3>
        </div>

        <form id="form_edit" name="form_edit" action="javascript:void(null);" onsubmit="callEdit('?route=settings/modules&active=<?php echo $VALID->inGET('type') ?>')" enctype="multipart/form-data">
            <div class="panel-body">
                <input id="edit" type="hidden" name="edit" value="<?php echo $VALID->inGET('type') . '_' . $VALID->inGET('name') ?>" />
                <div class="pull-right">
                    <input hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('button_on') ?>" data-off-text="<?php echo lang('button_off') ?>" name="switch" id="switch" <?php echo $switch ?>>
                </div>
                <div class="pull-left">
                    <div class="text-left"><?php echo lang('modules_name') ?> <?php echo lang($VALID->inGET('type') . '_' . $VALID->inGET('name') . '_name') ?></div>
                    <div class="text-left"><?php echo lang('modules_author') ?> <?php echo lang($VALID->inGET('type') . '_' . $VALID->inGET('name') . '_author') ?></div>
                    <div class="text-left"><?php echo lang('modules_version') ?> <?php echo lang($VALID->inGET('type') . '_' . $VALID->inGET('name') . '_version') ?></div>
                </div>
                <div class="clearfix"></div></br>

                <!--Выводим данные из модуля-->
                <?php require_once (ROOT . '/modules/' . $VALID->inGET('type') . '/' . $VALID->inGET('name') . '/controller/admin.php'); ?>

            </div>

            <div class="modal-footer">
                <button type="button" onClick='location.href = "?route=settings/modules&type=<?php echo $VALID->inGET('type') ?>"' class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-remove"></span> <?php echo lang('cancel') ?></button>
                <button type="submit" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-floppy-disk"></span> <?php echo lang('save') ?></button>
            </div>
        </form>

    </div>
</div>