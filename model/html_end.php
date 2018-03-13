<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/
?>
<?php
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

 //вывод только в админке
	if ($patch == 'admin'){ ?>
		
	<?php } // конец вывода только в админке
	?>
<?php //вывод только в каталоге
	if ($patch == 'catalog'){ ?>

		<?php 
	} // конец вывода только в каталоге
	?>
		<link rel="stylesheet" type="text/css" href="/view/default/admin/style.css" media="screen" />
		<script type="text/javascript" src="/ext/jquery/jquery.min.js"></script>
		<script src="/ext/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>