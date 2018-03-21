<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	/********  CONNECT PAGE START  ********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_start.php');
	/**************************************/
	
	// Устанавливаем родительскую категорию
	if(isset($_POST['parrent']) == TRUE){
		$parrent_id = $_POST['parrent'];
	}else{
		$parrent_id = 0;
	}

	// Если нажали на кнопку Добавить
	if(isset($_POST['name']) == TRUE && isset($_POST['parent_id']) == TRUE){
		$parrent_id = $_POST['parent_id'];
		
		if(isset($_POST['view_cat']) == 'on'){
			$view_cat = 1;
		}else{
			$view_cat = 0;
		}

		if($_POST['sort_category'] == false){
			$sort_category = 0;
		}else{
			$sort_category = $_POST['sort_category'];
		}
		// добавляем запись
		$PDO->insertPrepare("INSERT INTO ".TABLE_CATEGORIES." SET name=?, sort_category=?, parent_id=?, date_added=?, status=?", array($_POST['name'], $sort_category, $parrent_id, date("Y-m-d H:i:s"), $view_cat));
	}

	// Если нажали на кнопку Удалить
	if(isset($_POST['cat_delete']) == TRUE){
		// удаляем запись
		$PDO->insertPrepare("DELETE FROM ".TABLE_CATEGORIES." WHERE id=?", array($_POST['cat_delete']));
	}

	//КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
	$lines = array();
	$lines_page = 20; // задаем количество строк на странице вывода
	$i = 0;	// устанавливаем страницу в ноль при заходе
	$lines_p = $lines_page;

	$lines = $PDO->getColRow("SELECT * FROM ".TABLE_CATEGORIES." WHERE parent_id=?", array ($parrent_id)); // получаем содержимое в виде массива
	$lines = array_reverse($lines); // сортируем в обратном порядке
	$counter = count($lines);  //считаем количество строк

	if ($counter <= $lines_page) {
		$lines_p = $counter;
	}	
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
	if ($counter >= $lines_page) {
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
