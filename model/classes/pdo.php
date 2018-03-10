<?php
/*******************************
	Copyright © 2018 eMarket    
GNU GENERAL PUBLIC LICENSE v.3.0
********************************/

	namespace Model\Classes\Pdo;

	class PdoClass {

		function getQuery($sql) {
			global $DB;
			$result = $DB->query($sql);
			return $result;
		}
		// getQuery вместо $DB->query()



		function getExec($sql) {
			global $DB;
			$result = $DB->exec($sql);
			return $result;
		}
		// getExec вместо $DB->exec()



		function getCell($sql, $a) {
			global $DB;
			$exec = FALSE;
			if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetch($DB :: FETCH_NUM)); $exec = $cell[0];
			return $exec;
		}
	/* getCell для запроса точного значения ячейки.
	Если несколько вариантов, удовлетворяющих условию, то выдает только верхний.
	Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
	Если значение не найдено, то выдает пустой массив: Array()
	Запрос вида getCell("SELECT language FROM table WHERE id=?", array ('1')); выдаст конкретное значение russian - НЕ МАССИВ!
	Запрос вида getCell("SELECT * FROM table WHERE language=?", array ('russian')); выдаст значение первого поля, т.е. номер id.
	*/



		function getColRow($sql, $a) {
			global $DB;
			$exec = FALSE;
			if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetchAll($DB :: FETCH_NUM));
			return $exec;
		}
	/* getColRow для запроса колонки. Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
	Если значение не найдено, то выдает пустой массив: Array()
	Если применять в запросе getColRow("SELECT id FROM table WHERE language=?", array ('russian')) то выдаст все значения колонки id в виде массива,
	удовлетворяющие условию language='russian'.

	Array
	(
	    [0] => Array
	        (
	            [0] => 2
	        )

	    [1] => Array
	        (
	            [0] => 3
	        )
	)

	Если применить в запросе getColRow("SELECT * FROM table WHERE language=?", array ('russian')), то выдаст полностью данные всех ячеек строк(и),
	содержащих это условие (в массиве). Т.е. получится строковая выборка по условию:

	Array
	(
	    [0] => Array
	        (
	            [0] => 1
	            [1] => russian
	            [2] => mail@mail.ru
	            [3] => b0baee9d279d34fa1dfd71aadb908c3f
	            [4] => admin
	        )

	    [1] => Array
	        (
	            [0] => 3
	            [1] => russian
	            [2] => m@mail.ru
	            [3] => b0baee9d279d34fa1dfd71aadb908c3f
	            [4] => user
	        )
	)

	Если применить в запросе getColRow("SELECT id, language FROM table"), то выдаст таблицу из указанных колонок в массиве.

	Если применить в запросе getColRow("SELECT id, language FROM table WHERE language=?", array ('russian')), то выдаст таблицу из id
	и language, удовлетворяющих требованию language='russian'.

	Если применить в запросе getColRow("SELECT * FROM table"), то выдаст всю таблицу в массиве.
	*/



		function getCellFalse($sql, $a) {
			global $DB;
			$exec = FALSE;
			if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetchColumn());
			return $exec;
		}
/*getCellFalse выдает значение ячейки. Если ячейка не найдена то возвращает FALSE
Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах. Если значение не найдено, то выдает пустой массив: Array()
Использовать так: $a = getCellFalse("SELECT permission FROM users WHERE login=? AND password=?", array($_SESSION['login'],$_SESSION['password']));
*/



		function getColCount($sql, $a) {
			global $DB;
			$exec = FALSE;
			if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->ColumnCount());
			return $exec;
		}
	/* getColCount показывает количество столбцов в запросе. Результат выдается простым числовым значением.
Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах. Если значение не найдено, то выдает пустой массив: Array()
Использовать так: $a = getColCount("SELECT permission FROM users WHERE login=? AND password=?", array($_SESSION['login'],$_SESSION['password']));
	*/



		function getRowCount($sql, $a) {
			global $DB;
			$exec = FALSE;
			if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->RowCount());
			return $exec;
		}
	/* getRowCount показывает количество строк в запросе. Результат выдается простым числовым значением.
Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах. Если значение не найдено, то выдает пустой массив: Array()
Использовать так: $a = getRowCount("SELECT permission FROM users WHERE login=? AND password=?", array($_SESSION['login'],$_SESSION['password']));
	*/



		function selectPrepare($sql, $a) {
			global $DB;
			$exec = FALSE;
			if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetchAll() AND $exec = $exec[0][0]);
			return $exec;
		}
	/* selectPrepare показывает значение ячейки (не массив). Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
	Если значение не найдено, то выдает пустой массив: Array()
	Использовать так: $a = selectPrepare("SELECT permission FROM users WHERE login=? AND password=?", array($_SESSION['login'],$_SESSION['password']));
	*/



		function insertPrepare($sql, $a) {
			global $DB;
			$exec = FALSE;
			if ($exec = $DB->prepare($sql) AND $exec->execute($a));
			return $exec;
		}
	/* insertPrepare служит для INSERT INTO и UPDATE. Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых записях.
	Если значения нет, то передает пустой массив: Array()
	Использовать так: insertPrepare("INSERT INTO users SET login=?, password=?", array($_SESSION['login'],$_SESSION['password']));
	*/

	}

?>
