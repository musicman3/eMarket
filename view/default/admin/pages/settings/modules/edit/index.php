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
                <div class="pull-left"><a class="btn btn-primary btn-xs" href="?route=settings/modules"><span class="back glyphicon glyphicon-share-alt"></span></a> <?php echo lang('title_' . $VALID->inGET('type') . '_' . $VALID->inGET('name') . '_' . $SET->titleDir() . '_index') ?></div>
                <div class="clearfix"></div>
            </h3>
        </div>

        <!--Выводим данные из модуля-->
        <?php require_once (ROOT . '/modules/' . $VALID->inGET('type') . '/' . $VALID->inGET('name') . '/controller/admin.php'); ?>

    </div>
</div>