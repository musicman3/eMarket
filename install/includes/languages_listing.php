<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	//CREATE FILES LIST (LANGUAGES)
	$dirlist = array ();
	$dir='language/';
	$Open = opendir ($dir);
	while ($file = readdir ($Open)) {
		$filenam = $dir . $file;
		if (is_file ($filenam)) {
			$dirlist[] = substr($file, 0, -4);
		}
	}
	closedir ($Open);
	sort($dirlist);

	//LOAD LANGUAGE
	$deflang = $dirlist[0];
	if(isset($_POST['language'])){
		$deflang = $_POST['language'];
	}

	require_once 'language/'.$deflang.'.php';

?>