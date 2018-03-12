<?php
/****** Copyright � 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	/********  CONNECT PAGE START  ********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_start.php');
	/**************************************/
	
	//POST FORM
	if(isset($_POST['project_name']) && isset($_POST['project_status'])){
		$project_name = $_POST['project_name'];
		$project_status = $_POST['project_status'];
	}
	
	//ADD PROJECT
	$PDO->insertPrepare("INSERT INTO csd_project SET project_name=?, date_create=?, project_status=?", array($project_name, date("Y-m-d H:i:s"), $project_status));

	/*********  CONNECT PAGE END  *********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_end.php');
	/**************************************/

?>