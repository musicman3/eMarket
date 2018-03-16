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
	// если начальная страница
	$lines_p = 20;
	$i = 0;
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log')) {
		// Получаем содержимое файла в виде массива
		$lines = file($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log');
		// сортируем в обратном порядке
		$lines = array_reverse($lines);
		// считаем количество строк
		$counter = count($lines);
		$counter_max = $counter - 21;

		if(isset($_POST['lines_p']) && isset($_POST['i'])){
			// назначаем количество строк на странице
			$lines_p = $_POST['lines_p'] + 20;
			//задаем значение счетчика
			$i = $_POST['i'] + 20;

		}
		if(isset($_POST['lines_p2']) && isset($_POST['i2'])){
			// назначаем количество строк на странице
			$lines_p = $_POST['lines_p2'] - 20;
			//задаем значение счетчика
			$i = $_POST['i2'] - 20;
			if ($i <0) {
				$i = 0;
			}
			if ($lines_p <20) {
				$lines_p = 20;
			}
			if ($i >= $counter_max) {
				$i = $counter_max-20;
			}
			if ($lines_p >= $counter) {
				$lines_p = $counter-20;
			}

		}
		

	}

	/*********  CONNECT PAGE END  *********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_end.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/html_end.php');
	/**************************************/

?>
