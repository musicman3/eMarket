<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	/********  CONNECT PAGE START  ********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_start.php');

	/**************************************/
	
	$lines = array();
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log')) {
	// Получаем содержимое файла в виде массива
	$lines = file($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log');
	}

	/*********  CONNECT PAGE END  *********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_end.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/html_end.php');
	/**************************************/

?>
