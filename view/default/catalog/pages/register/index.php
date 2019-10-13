<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>
<!--Выводим уведомление об успешном действии-->
<?php \eMarket\Other\Messages::alert(); ?>
<h1><?php echo lang('register_account') ?></h1>

<div id="register" class="contentText">
    <form enctype="multipart/form-data" method="post" action="" onchange="validate()">
	<fieldset id="account">
	    <legend><?php echo lang('personal_details') ?></legend>
	    <div class="input-group has-error firstname">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		<input class="form-control" type="text" placeholder="<?php echo lang('first_name') ?>" minlength="1" id="input-firstname" value="" name="firstname" required>
	    </div>
	    <br>
	    <div class="input-group has-error lastname">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		<input class="form-control" type="text" placeholder="<?php echo lang('last_name') ?>" minlength="1" id="input-lastname" value="" name="lastname" required>
	    </div>
	    <br>
	    <div class="input-group has-error email">
		<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
		    <input class="form-control" type="email" placeholder="<?php echo lang('e_mail') ?>" id="input-email" value="" name="email" required>
	    </div>
	    <br>
	    <div class="input-group has-success">
		<span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
		<input class="form-control" type="tel" placeholder="<?php echo lang('telephone') ?>" id="input-telephone" value="" name="telephone">
	    </div>
	    <br>
	</fieldset>
	<fieldset>
	    <legend><?php echo lang('details_password') ?></legend>
	    <div class="input-group has-error password">
		<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
		<input class="form-control" type="password" minlength="7" maxlength="40" placeholder="<?php echo lang('password') ?>" id="input-password" value="" name="password" required>
	    </div>
	    <br>
	    <div class="input-group has-error confirm">
		<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
		<input class="form-control" type="password" minlength="7" maxlength="40" placeholder="<?php echo lang('confirm_password') ?>" id="input-confirm" value="" name="confirm" required>
	    </div>
	    <br>
	</fieldset>
	<div class="text-right"><?php echo lang('privacy_statement_agree') ?>
	    <input type="checkbox" value="1" name="agree">&nbsp;
	    <input class="btn btn-primary" type="submit" value="<?php echo lang('continue') ?>">
	</div>
	<br>
    </form>
</div>