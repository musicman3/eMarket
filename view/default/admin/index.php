<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>

<?php 	if(isset($_SESSION['login']) && isset($_SESSION['pass'])){ // Выводим если авторизованы ?>
    <div class="container">
        <!-- Example row of columns -->

        <div class="row">
	          <div class="col-md-12">
	          
<div class="welcome text-center">
	Добро пожаловать в систему управления контентом
	<div class="welcome_logo">eMarket <span>v1</span></div>
	<div class="welcome_description">Вы можете задать интересующие Вас вопросы по функционированию сайта, а также обсудить любую другую информацию относительно системы управления, по E-Mail: <strong>cms@gmail.com<strong></strong></strong></div><strong><strong>	
</strong></strong></div>

	          </div>

        </div>
    </div><!-- /container -->
<?php } ?>