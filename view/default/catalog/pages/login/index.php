<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

?>

<h1>Добро пожаловать, пожалуйста войдите</h1>

<div id="login" class="contentText">
    <div class="row">
	<div class="col-sm-6">
	    <div class="panel panel-info">
		<div class="panel-body">
		    <legend>Постоянный клиент</legend>
		    <div class="form-group has-error email">
			<input type="email" class="form-control" placeholder="E-Mail" id="input-email" name="email" required>
		    </div>
		    <div class="form-group has-error password">
			<input type="password" class="form-control" minlength="6" maxlength="40" placeholder="Введите пароль" id="input-password" name="password" required>
		    </div>
		    <div class="form-group">
			<button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-log-in"></span> Войти</button>
		    </div>
		    <a class="btn btn-default" role="button" href="">Забыли пароль? Кликните сюда.</a>
		</div>
	    </div>
	</div>
	<div class="col-sm-6">
	    <div class="panel panel-info">
		<div class="panel-body">
		    <legend>Новый покупатель</legend>
		    <p>Создав учетную запись в eMarket, вы сможете делать покупки быстрее, быть в курсе статуса заказов и отслеживать заказы, которые вы уже сделали ранее.</p>
		    <a href="/?route=register" class="btn btn-primary btn-block"> <span class="glyphicon glyphicon-chevron-right"></span> Продолжить</a>
		</div>
	    </div>
	</div>
    </div>
</div>