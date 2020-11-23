<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ПОДКЛЮЧАЕМ КОНТЕНТ
foreach (\eMarket\View::layoutRouting('content') as $path) {
    require_once (ROOT . $path);
}
?>

<!--Выводим уведомление об успешном действии-->
<?php \eMarket\Messages::alert(); ?>
<h1><?php echo lang('my_account_name') ?></h1>

<div id="my_account" class="contentText">
    <form name="form_edit" id="form_edit" action="javascript:void(null);" onchange="validate()" onsubmit="callEdit()">
        <input type="hidden" id="edit" name="edit" value="ok" />
        <div class="row">

            <div class="col-sm-6">
                <div class="form-group">
		    <legend><?php echo lang('my_account_personal_details') ?></legend>
                    <small class="form-text text-muted"><?php echo lang('my_account_firstname') ?></small>
                    <div class="input-group has-success">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <input class="input-sm form-control" placeholder="<?php echo lang('my_account_enter_your_firstname') ?>" type="text" name="firstname" id="firstname" value="<?php echo $CUSTOMER['firstname'] ?>" />
                    </div>

                    <small class="form-text text-muted"><?php echo lang('my_account_lastname') ?></small>
                    <div class="input-group has-success">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <input class="input-sm form-control" placeholder="<?php echo lang('my_account_enter_your_lastname') ?>" type="text" name="lastname" id="lastname" value="<?php echo $CUSTOMER['lastname'] ?>" />
                    </div>

                    <small class="form-text text-muted"><?php echo lang('my_account_middlename') ?></small>
                    <div class="input-group has-success">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <input class="input-sm form-control" placeholder="<?php echo lang('my_account_enter_your_middlename') ?>" type="text" name="middle_name" id="middle_name" value="<?php echo $CUSTOMER['middle_name'] ?>" />
                    </div>
                    
                    <small class="form-text text-muted"><?php echo lang('my_account_telephone') ?></small>
                    <div class="input-group has-success">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <input class="input-sm form-control" placeholder="<?php echo lang('my_account_enter_your_phone') ?>" type="text" name="telephone" id="lastname" value="<?php echo $CUSTOMER['telephone'] ?>" />
                    </div>

                </div>
            </div>

            <div class="col-sm-6">
                <div class="form-group">
		    <legend><?php echo lang('my_account_details_password') ?></legend>
                    <small class="form-text text-muted"><?php echo lang('my_account_password') ?></small>
                    <div class="input-group has-success password">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <input class="input-sm form-control password-data" minlength="7" maxlength="40" placeholder="<?php echo lang('my_account_enter_your_password') ?>" type="password" name="password" id="password" />
                    </div>

                    <small class="form-text text-muted"><?php echo lang('my_account_confirm_password') ?></small>
                    <div class="input-group has-success confirm">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-pencil"></span></span>
                        <input class="input-sm form-control password-data" minlength="7" maxlength="40" placeholder="<?php echo lang('my_account_confirm_your_password') ?>" type="password" name="confirm_password" id="confirm_password" />
                    </div>
		</div>
	    </div>

	</div>

	<div class="text-right form-group">
	    <input id="submit_btn" class="btn btn-primary" type="submit" value="<?php echo lang('save') ?>">
	</div>

    </form>
</div>
