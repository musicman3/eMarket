<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	//REQUIRE CONFIGURE.PHP
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/configure/configure.php');

	//SESSION = POST FORM
	session_start();
	if(isset($_POST['login']) && isset($_POST['pass'])){
		$_SESSION['login'] = $_POST['login'];
		$_SESSION['pass'] = hash(HASH_METHOD, $_POST['pass']);
	}

	//REQUIRE CONNECT.PHP
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/configure/connect.php');

	//REQUIRE PDO.PHP
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/classes/pdo.php');

	//LOAD CLASS PDO
	$PDO = new Model\Classes\Pdo\PdoClass;

	//VERIFY USER
	$verify = $PDO->getRowCount("SELECT * FROM ".TABLE_USERS." WHERE login=? AND password=?", array($_SESSION['login'], $_SESSION['pass']));

	if($verify != 1){    //if user failed:

		header('Location: /controller/admin/verify/login_error.php');    // if user failed: redirect to login_error.php
	}else{
		header('Location: /controller/admin/index.php');    // else: redirect to index.php
	}

	$deflang = $PDO->selectPrepare("SELECT language FROM ".TABLE_USERS." WHERE login=? AND password=?", array($_SESSION['login'], $_SESSION['pass']));
	$_SESSION['default_language'] = $deflang;

	//END CONNECT DATABASE
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_end.php');

?>