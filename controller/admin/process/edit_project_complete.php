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
		$id = $_POST['edit_id'];
	}
	
	if (isset($_POST['project_delete']) == 'on') {
		
		//DELETE PROJECT
		$PDO->insertPrepare("DELETE FROM csd_project WHERE id=?", array($id));

	}else{

		//EDIT PROJECT
		$PDO->insertPrepare("UPDATE csd_project SET project_name=?, project_status=? WHERE id=?", array($project_name, $project_status, $id));
	}

	/*********  CONNECT PAGE END  *********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_end.php');
	/**************************************/

?>