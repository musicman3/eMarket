<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h1><?php echo lang('log_in') ?></h1>

<div id="login" class="contentText">
    <div class="row">
	<div class="col-sm-6">
	    <div class="panel panel-info">
		<div class="panel-body">
		    <legend><?php echo lang('returning_customer') ?></legend>
		    <div class="form-group has-error email">
			<input class="form-control" type="email" placeholder="<?php echo lang('e_mail') ?>" id="input-email" name="email" required>
		    </div>
		    <div class="form-group has-error password">
			<input class="form-control" type="password" minlength="6" maxlength="40" placeholder="<?php echo lang('password') ?>" id="input-password" name="password" required>
		    </div>
		    <div class="form-group">
			<button class="btn btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> <?php echo lang('sign_in') ?></button>
		    </div>
		    <a class="btn btn-default" role="button" href=""><?php echo lang('password_no') ?></a>
		</div>
	    </div>
	</div>
	<div class="col-sm-6">
	    <div class="panel panel-info">
		<div class="panel-body">
		    <legend><?php echo lang('new_customer') ?></legend>
		    <p><?php echo lang('log_in_description') ?></p>
		    <a href="/?route=register" class="btn btn-primary btn-block"> <span class="glyphicon glyphicon-chevron-right"></span> <?php echo lang('continue') ?></a>
		</div>
	    </div>
	</div>
    </div>
</div>