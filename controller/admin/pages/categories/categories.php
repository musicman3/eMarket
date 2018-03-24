<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	/********  CONNECT PAGE START  ********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_start.php');
	/**************************************/

	$parent_id = 0; // Устанавливаем родительскую категорию при первом заходе
	
	// Устанавливаем родительскую категорию при переходе на уровень выше
	if(isset($_POST['parent_up']) == TRUE){
		$parent_id = $PDO->selectPrepare("SELECT parent_id FROM ".TABLE_CATEGORIES." WHERE id=?", array($_POST['parent_up']));
	}

	// Устанавливаем родительскую категорию при переходе на уровень ниже
	if(isset($_POST['parent_down']) == TRUE){
		$parent_id = $_POST['parent_down'];
	}

	// Если нажали на кнопку Добавить
	if(isset($_POST['name']) == TRUE && isset($_POST['parent_id']) == TRUE){
		// Устанавливаем родительскую категорию
		$parent_id = $_POST['parent_id'];
		
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
		$PDO->insertPrepare("INSERT INTO ".TABLE_CATEGORIES." SET name=?, sort_category=?, parent_id=?, date_added=?, status=?", array($_POST['name'], $sort_category, $parent_id, date("Y-m-d H:i:s"), $view_cat));
	}

	// Если нажали на кнопку Удалить
	if(isset($_POST['cat_delete']) == TRUE){

		// Устанавливаем родительскую категорию
		$parent_id = $PDO->selectPrepare("SELECT parent_id FROM ".TABLE_CATEGORIES." WHERE id=?", array($_POST['cat_delete']));
		// Устанавливаем родительскую категорию родительской категории
		$parent_id_up = $PDO->selectPrepare("SELECT parent_id FROM ".TABLE_CATEGORIES." WHERE id=?", array($parent_id));
		// считаем одинаковые parent_id
		$parent_id_num = $PDO->getColRow("SELECT id FROM ".TABLE_CATEGORIES." WHERE parent_id=?", array($parent_id));
		// если меньше 2-х значений, то устанавливаем parent_id как родительский родительского
		if(count($parent_id_num) < 2 ){
			$parent_id = $parent_id_up;
		}
	
		//Выбираем данные из БД
		$data_cat = $DB->prepare("SELECT id, parent_id FROM ".TABLE_CATEGORIES);
		$data_cat->execute();

		$category = $_POST['cat_delete']; // id родителя
		$categories  = array();
		$keys = array(); // массив ключей
		$keys[] = $category; // добавляем первый ключ в массив

		// В цикле формируем ассоциативный массив разделов
		while($category =  $data_cat->fetch(PDO::FETCH_ASSOC)){
			// Проверяем наличие id категории в массиве ключей
			if (in_array($category['parent_id'], $keys)) {
				$categories[$category['parent_id']][] = $category['id'];
				$keys[] = $category['id']; // расширяем массив
			}
		}

		for ($x = 0; $x < count($keys); $x++){
			//Удаляем подкатегории
			$PDO->insertPrepare("DELETE FROM ".TABLE_CATEGORIES." WHERE id=?", array($keys[$x]));
		}
		//удаляем основную категорию
		$PDO->insertPrepare("DELETE FROM ".TABLE_CATEGORIES." WHERE id=?", array($_POST['cat_delete']));
	}

	// КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
	$lines = array();
	$lines_page = 20; // задаем количество строк на странице вывода
	$i = 0;	// устанавливаем страницу в ноль при заходе
	$lines_p = $lines_page;
	
	// Если parrent_id является массивом, то
	if (is_array($parent_id) == TRUE){
		$parent_id = 0;
	}

	// Устанавливаем родительскую категорию при навигации назад-вперед
	if(isset($_POST['parent_id_temp']) == TRUE){
		$parent_id = $_POST['parent_id_temp'];
	}
	// получаем отсортированное по sort_category содержимое в виде массива
	$lines = $PDO->getColRow("SELECT * FROM ".TABLE_CATEGORIES." WHERE parent_id=? ORDER BY sort_category DESC", array ($parent_id));
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
	// КОНЕЦ-> КНОПКИ НАВИГАЦИИ НАЗАД-ВПЕРЕД И ПОСТРОЧНЫЙ ВЫВОД ТАБЛИЦЫ
	
	// если сортируем категории мышкой
	$j = $i; //  переменная для передачи POST в javascript сортировки
	if (isset($_POST['ids'])){
		$j2 = $_POST['j'];
		$sort_ajax = explode(',' , $_POST['ids']);
		for ($ajax_i = 0; $ajax_i < count($sort_ajax); $ajax_i++) { 
			$PDO->insertPrepare("UPDATE ".TABLE_CATEGORIES." SET sort_category=? WHERE id=?", array($ajax_i+$j2, $sort_ajax[$ajax_i]));
		}
	}

	/*********  CONNECT PAGE END  *********/
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/connect_page_end.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/html_end.php');
	/**************************************/

?>
