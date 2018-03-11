<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	namespace Model\Classes\Parser;

	class FilesParserClass {

		//ФУНКЦИЯ ПОЛУЧЕНИЯ ПОЛНОГО ПУТИ К ФАЙЛАМ С УЧЕТОМ ПОДКАТЕГОРИЙ (БЕЗ ПУСТЫХ ПАПОК)
		function ParserPatch($dir)  {
			$handle = opendir($dir) or die("Error: Can't open directory $dir");  
			$files = Array();  
			$subfiles = Array();  
			while (false !== ($file = readdir($handle)))  {
				if ($file != "." && $file != ".." && $file != ".gitkeep")  {
					if(is_dir($dir."/".$file))  {
	  
						// Получим список файлов вложенной папки...  
						$subfiles = ParserPatch($dir."/".$file);  
		
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

	}

?>