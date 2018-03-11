<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	//LOAD CONFIGURE.PHP
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/configure/configure.php');
	//LOAD LANGUAGE
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/lang_router.php');

	require_once($_SERVER['DOCUMENT_ROOT'].'/model/router_out.php');

	if(!isset($_POST['ok'])) {
		// если форма не заполнена, то выводим ее

		require_once($_SERVER['DOCUMENT_ROOT'].'/model/html_start.php');

		//LOAD TEMPLATE
		require_once($View->Routing());

		require_once($_SERVER['DOCUMENT_ROOT'].'/model/html_end.php');

	}
?>