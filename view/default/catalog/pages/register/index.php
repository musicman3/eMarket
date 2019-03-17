<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h1>Регистрация аккаунта</h1>

<div id="register" class="contentText">
    <form class="form-horizontal" enctype="multipart/form-data" method="post" action="">
	<fieldset id="account">
	    <legend>Ваши персональные данные</legend>
	    <div class="form-group required">
		<label for="input-firstname" class="col-sm-2 control-label">Имя</label>
		<div class="col-sm-10">
		    <input type="text" class="form-control" id="input-firstname" value="" name="firstname">
		</div>
	    </div>
	    <div class="form-group required">
		<label for="input-lastname" class="col-sm-2 control-label">Фамилия</label>
		<div class="col-sm-10">
		    <input type="text" class="form-control" id="input-lastname" value="" name="lastname">
		</div>
	    </div>
	    <div class="form-group required">
		<label for="input-email" class="col-sm-2 control-label">E-Mail</label>
		<div class="col-sm-10">
		    <input type="email" class="form-control" id="input-email" value="" name="email">
		</div>
	    </div>
	    <div class="form-group required">
		<label for="input-telephone" class="col-sm-2 control-label">Телефон</label>
		<div class="col-sm-10">
		    <input type="tel" class="form-control" id="input-telephone" value="" name="telephone">
		</div>
	    </div>
	</fieldset>
	<fieldset>
	    <legend>Ваш пароль</legend>
	    <div class="form-group required">
		<label for="input-password" class="col-sm-2 control-label">Пароль</label>
		<div class="col-sm-10">
		    <input type="password" class="form-control" id="input-password" value="" name="password">
		</div>
	    </div>
	    <div class="form-group required">
		<label for="input-confirm" class="col-sm-2 control-label">Подтвердить пароль</label>
		<div class="col-sm-10">
		    <input type="password" class="form-control" id="input-confirm" value="" name="confirm">
		</div>
	    </div>
	</fieldset>
	<div class="pull-right">Я прочитал и согласен с <a class="agree" href="#"><b>условиями</b></a> политики конфиденциальности.
	    <input type="checkbox" value="1" name="agree">&nbsp;
	    <input type="submit" class="btn btn-primary" value="Продолжить">
	</div>
    </form>
</div>