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
	    <div class="input-group has-error">
		<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
		<input type="text" class="form-control" placeholder="Имя" id="input-firstname" value="" name="firstname">
	    </div>
	    <br>
	    <div class="input-group has-error">
		<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
		<input type="text" class="form-control" placeholder="Фамилия" id="input-lastname" value="" name="lastname">
	    </div>
	    <br>
	    <div class="input-group has-error">
		<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
		    <input type="email" class="form-control" placeholder="E-Mail" id="input-email" value="" name="email">
	    </div>
	    <br>
	    <div class="input-group has-info">
		<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
		<input type="tel" class="form-control" placeholder="Телефон" id="input-telephone" value="" name="telephone">
	    </div>
	    <br>
	</fieldset>
	<fieldset>
	    <legend>Ваш пароль</legend>
	    <div class="input-group has-error">
		<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
		<input type="password" class="form-control" placeholder="Пароль" id="input-password" value="" name="password">
	    </div>
	    <br>
	    <div class="input-group has-error">
		<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
		<input type="password" class="form-control" placeholder="Подтвердить пароль" id="input-confirm" value="" name="confirm">
	    </div>
	    <br>
	</fieldset>
	<div class="pull-right">Я прочитал и согласен с <a class="agree" href="#"><b>условиями</b></a> политики конфиденциальности.
	    <input type="checkbox" value="1" name="agree">&nbsp;
	    <input type="submit" class="btn btn-primary" value="Продолжить">
	</div>
    </form>
</div>