<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	/********  CONNECT PAGE START  ********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_start.php');
	/**************************************/
	
	// Если нажали на кнопку Удалить
	if(isset($_POST['log_delete']) == 'delete'){
		// удаляем лог
		unlink($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log');
	}

	//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
	$lines = array();
	$lines_page = 20; // задаем количество строк на странице вывода
	$i = 0;	// устанавливаем страницу в ноль при заходе
	$lines_p = $lines_page;
	// Если файл открыт, то
	if (file_exists($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log')) { // Если файл существует, то
		$lines = file($_SERVER['DOCUMENT_ROOT'].'/model/work/errors.log'); // получаем содержимое файла в виде массива
		$lines = array_reverse($lines); // сортируем в обратном порядке
		$counter = count($lines); // считаем количество строк
		
		// Если нажали на кнопку вперед
		if(isset($_POST['lines_p']) && isset($_POST['i'])){
			$lines_p = $_POST['lines_p'] + $lines_page; // пересчитываем количество строк на странице
			$i = $_POST['i'] + $lines_page; // задаем значение счетчика
			if ($i >= $counter) {
				$i = $_POST['i'];
			}
			if ($lines_p >= $counter) {
				$lines_p = $counter;
			}	
		}
		// Если нажали на кнопку назад
		if(isset($_POST['lines_p2']) && isset($_POST['i2'])){
			$lines_p = $_POST['i2']; // пересчитываем количество строк на странице
			$i = $_POST['i2'] - $lines_page; // задаем значение счетчика
			if ($i < 0) {
				$i = 0;
			}
			if ($lines_p < $lines_page) {
				$lines_p = $lines_page;
			}
		}
	}
	//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ

	/*********  CONNECT PAGE END  *********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_end.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/html_end.php');
	/**************************************/

?>
