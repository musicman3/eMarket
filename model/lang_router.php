<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	//ФУНКЦИЯ ПОЛУЧЕНИЯ ПОЛНОГО ПУТИ К ФАЙЛАМ С УЧЕТОМ ПОДКАТЕГОРИЙ (БЕЗ ПУСТЫХ ПАПОК)
	function FilesPatch($dir)  {
		$handle = opendir($dir) or die("Error: Can't open directory $dir");  
		$files = Array();  
		$subfiles = Array();  
		while (false !== ($file = readdir($handle)))  {
			if ($file != "." && $file != ".." && $file != '.gitkeep')  {
				if(is_dir($dir."/".$file))  {
  
					// Получим список файлов вложенной папки...  
					$subfiles = FilesPatch($dir."/".$file);  
	
					// ...и добавим их к общему списку  
					$files = array_merge($files,$subfiles);  
				} else{
					$files[] = $dir."/".$file;
				}
			}
		}
		closedir($handle);  
		return $files;  
	}

	//Текущий основной путь (admin или catalog)
	$uri_explode = explode('/', ($_SERVER['REQUEST_URI']));

	if ($uri_explode[2] == 'admin'){
		$patch =  'admin';
	}
	if ($uri_explode[2] == 'catalog'){
		$patch = 'catalog';
	}

	//Подключение и парсинг языкового файла
	$files_patch = FilesPatch($_SERVER['DOCUMENT_ROOT'].'/language/'.DEFAULT_LANGUAGE.'/'.$patch);
	$parse_temp = parse_ini_file ($files_patch[0]);
	for ($i = 0; $i < count($files_patch); $i++)
	{
		$ini = parse_ini_file ($files_patch[$i]);
		
		$lang = array_merge ($parse_temp, $ini); // Установка языкового массива
	} 
?>