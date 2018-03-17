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
	// задаем количество строк на странице вывода
	$lines_p = 20;
	$lines_page = 20;
	// устанавливаем страницу в ноль при заходе
	$i = 0;
	
	// Если нажали на кнопку Удалить
	if(isset($_POST['log_delete']) == 'delete'){
		// назначаем количество строк на странице
		unlink($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log');
		}

	// Если файл открыт, то
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log')) {
		// Получаем содержимое файла в виде массива
		$lines = file($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log');
		// сортируем в обратном порядке
		$lines = array_reverse($lines);
		// считаем количество строк
		$counter = count($lines);
		
		// Если нажали на кнопку вперед
		if(isset($_POST['lines_p']) && isset($_POST['i'])){
			// назначаем количество строк на странице
			$lines_p = $_POST['lines_p'] + $lines_page;
			//задаем значение счетчика
			$i = $_POST['i'] + $lines_page;
			if ($i > $counter-$lines_page) {
				$i = $counter-$lines_page;
			}
			if ($lines_p > $counter) {
				$lines_p = $counter;
			}	
		}
		
		// Если нажали на кнопку назад
		if(isset($_POST['lines_p2']) && isset($_POST['i2'])){
			// назначаем количество строк на странице
			$lines_p = $_POST['lines_p2'] - $lines_page;
			//задаем значение счетчика
			$i = $_POST['i2'] - $lines_page;
			if ($i <0) {
				$i = 0;
			}
			if ($lines_p <$lines_page) {
				$lines_p = $lines_page;
			}
		}
	
	}

	/*********  CONNECT PAGE END  *********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_end.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/html_end.php');
	/**************************************/

?>
