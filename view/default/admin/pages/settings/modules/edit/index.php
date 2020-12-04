<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
?>

<div id="settings_modules_edit" class="panel panel-default shadow-element">

    <div class="panel-heading">
	<!--Выводим уведомление об успешном действии-->
	<div id="alert_block"><?php \eMarket\Messages::alert(); ?></div>
	<h3 class="panel-title">
	    <span class="settings_back"><button type="button" onClick='location.href = "<?php echo \eMarket\Set::parentPartitionGenerator() ?>"' class="btn btn-primary btn-xs"><span class="back glyphicon glyphicon-share-alt"></span></button></span><span class="settings_name"><?php echo \eMarket\Set::titlePageGenerator() ?></span>
	</h3>
    </div>
    <div class="panel-body">
	<form id="form_edit_active" name="form_edit_active" enctype="multipart/form-data">
	    <input id="edit_active" type="hidden" name="edit_active" value="<?php echo \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') ?>" />
	    <div class="pull-right">
		<input hidden type="checkbox" data-off-color="danger" data-size="mini" data-on-text="<?php echo lang('button_on') ?>" data-off-text="<?php echo lang('button_off') ?>" name="switch_active" id="switch_active" <?php echo $switch_active ?>>
	    </div>
	</form>
	<div class="pull-left">
	    <div class="text-left"><?php echo lang('modules_name') ?> <?php echo lang('modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') . '_name') ?></div>
	    <div class="text-left"><?php echo lang('modules_author') ?> <?php echo lang('modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') . '_author') ?></div>
	    <div class="text-left"><?php echo lang('modules_version') ?> <?php echo lang('modules_' . \eMarket\Valid::inGET('type') . '_' . \eMarket\Valid::inGET('name') . '_version') ?></div>
	</div>
	<div class="clearfix"></div></br>

	<!--Выводим данные из модуля-->
	<?php require_once (\eMarket\View::routingModules('controller') . '/index.php'); ?>

    </div>

</div>