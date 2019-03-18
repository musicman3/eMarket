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
	    <div class="input-group has-error firstname">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		<input type="text" class="form-control" placeholder="Имя" id="input-firstname" value="" name="firstname" required>
	    </div>
	    <br>
	    <div class="input-group has-error lastname">
		<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
		<input type="text" class="form-control" placeholder="Фамилия" id="input-lastname" value="" name="lastname" required>
	    </div>
	    <br>
	    <div class="input-group has-error email">
		<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
		    <input type="email" class="form-control" type="email" placeholder="E-Mail" id="input-email" value="" name="email" required>
	    </div>
	    <br>
	    <div class="input-group has-success">
		<span class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></span>
		<input type="tel" class="form-control" placeholder="Телефон" id="input-telephone" value="" name="telephone">
	    </div>
	    <br>
	</fieldset>
	<fieldset>
	    <legend>Ваш пароль</legend>
	    <div class="input-group has-error">
		<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
		<input type="password" class="form-control" type="password" minlength="6" placeholder="Пароль" id="input-password" value="" name="password" required>
	    </div>
	    <br>
	    <div class="input-group has-error">
		<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
		<input type="password" class="form-control" type="password" minlength="6" placeholder="Подтвердить пароль" id="input-confirm" value="" name="confirm" required>
	    </div>
	    <br>
	</fieldset>
	<div class="text-right">Я прочитал и согласен с <a class="agree" href="#"><b>условиями</b></a> политики конфиденциальности.
	    <input type="checkbox" value="1" name="agree">&nbsp;
	    <input type="submit" class="btn btn-primary" value="Продолжить">
	</div>
	<br>
    </form>
</div>