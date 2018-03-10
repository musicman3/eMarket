<?php
/****** Copyright © 2018 eMarket ******* 
	Copyright © 2018 eMarket    
* https://github.com/musicman3/eMarket *
****************************************/

	error_reporting(-1);

	session_start();

	$login = null;
	$pass = null;
	if(isset($_SESSION['login']) && isset($_SESSION['pass'])){
		$login= $_SESSION['login'];
		$pass= $_SESSION['pass'];
	}

	$verify = $PDO->getRowCount("SELECT * FROM ".TABLE_USERS." WHERE login=? AND password=?", array($login, $pass));
	if($verify != 1){ //NO USER
		header('Location: /controller/verify/login.php'); // REDIRECT TO LOGIN.PHP
	}

?>