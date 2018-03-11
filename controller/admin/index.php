<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	/********  CONNECT PAGE START  ********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_start.php');
	***************************************/

	$table = $PDO->getColRow("SELECT * FROM csd_project", array());

	//SELECT HASH-METHOD
	if (HASH_METHOD == 'gost'){
		$hash = $lang['hash_gost'];
	}
	if (HASH_METHOD == 'sha256'){
		$hash = $lang['hash_sha256'];
	}

	//SELECT CRYPT-METHOD
	if (CRYPT_METHOD == 'gost'){
		$crypt = $lang['crypt_gost'];
	}
	if (CRYPT_METHOD == 'blowfish'){
		$crypt = $lang['crypt_blowfish'];
	}
	if (CRYPT_METHOD == 'rijndael-256'){
		$crypt = $lang['crypt_rijndael-256'];
	}

	/*********  CONNECT PAGE END  *********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_end.php');
	***************************************/

?>
