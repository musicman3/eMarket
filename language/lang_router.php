<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	//Текущий основной путь (admin или catalog)
	$uri_explode = explode('/', ($_SERVER['REQUEST_URI']));

	if ($uri_explode[2] == 'admin'){
		$patch =  'admin';
	}
	if ($uri_explode[2] == 'catalog'){
		$patch = 'catalog';
	}

	//Подключение и парсинг языкового файла
	$lang_file = $_SERVER['DOCUMENT_ROOT'].'/language/'.$_SESSION['default_language'].'/'.$patch.'/'.$_SESSION['default_language'].'.lng';
	$lang_temp = parse_ini_file($lang_file, TRUE);
	$lang =  $lang_temp[$patch];

?>