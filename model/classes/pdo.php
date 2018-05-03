<?php

// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

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
        if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetch($DB :: FETCH_NUM))
            ;
        $exec = $cell[0];
        return $exec;
    }

    /* getCell для запроса точного значения ячейки.
      Если несколько вариантов, удовлетворяющих условию, то выдает только верхний.
      Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
      Если значение не найдено, то выдает пустой массив: Array()
      Запрос вида $PDO->getCell("SELECT language FROM table WHERE id=?", ['1']); выдаст конкретное значение russian - НЕ МАССИВ!
      Запрос вида $PDO->getCell("SELECT * FROM table WHERE language=?", ['russian']); выдаст значение первого поля, т.е. номер id.
     */

    function getColRow($sql, $a) {
        global $DB;
        $exec = FALSE;
        if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetchAll($DB :: FETCH_NUM))
            ;
        return $exec;
    }

    /* getColRow для запроса колонки. Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
      Если значение не найдено, то выдает пустой массив: Array()
      Если применять в запросе $PDO->getColRow("SELECT id FROM table WHERE language=?", ['russian']) то выдаст все значения колонки id в виде массива,
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

      Если применить в запросе $PDO->getColRow("SELECT * FROM table WHERE language=?", ['russian']), то выдаст полностью данные всех ячеек строк(и),
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

      Если применить в запросе $PDO->getColRow("SELECT id, language FROM table", array()), то выдаст таблицу из указанных колонок в массиве.

      Если применить в запросе $PDO->getColRow("SELECT id, language FROM table WHERE language=?", ['russian']), то выдаст таблицу из id
      и language, удовлетворяющих требованию language='russian'.

      Если применить в запросе $PDO->getColRow("SELECT * FROM table", array()), то выдаст всю таблицу в массиве.
     */

    function getCol($sql, $a) {
        global $DB;
        $exec = FALSE;
        if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetchAll($DB :: FETCH_NUM))
            ;
        $exec = array_column($exec, 0);
        return $exec;
    }

    /* getCol для запроса колонки в виде одномерного массива. Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
      Если значение не найдено, то выдает пустой массив: Array()
      Если применять в запросе $PDO->getColRow("SELECT name FROM table WHERE language=?", ['russian']) то выдаст все значения колонки id в виде одномерного массива,
      удовлетворяющие условию language='russian'.

      Array
      (
      [0] => Name1
      [1] => Name2
      )
     */

    function getCellFalse($sql, $a) {
        global $DB;
        $exec = FALSE;
        if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetchColumn())
            ;
        return $exec;
    }

    /* getCellFalse выдает значение ячейки. Если ячейка не найдена то возвращает FALSE
      Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах. Если значение не найдено, то выдает пустой массив: Array()
      Использовать так: $a = $PDO->getCellFalse("SELECT permission FROM users WHERE login=? AND password=?", [$_SESSION['login'],$_SESSION['password']]);
     */

    function getColCount($sql, $a) {
        global $DB;
        $exec = FALSE;
        if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->ColumnCount())
            ;
        return $exec;
    }

    /* getColCount показывает количество столбцов в запросе. Результат выдается простым числовым значением.
      Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах. Если значение не найдено, то выдает пустой массив: Array()
      Использовать так: $a = $PDO->getColCount("SELECT permission FROM users WHERE login=? AND password=?", [$_SESSION['login'],$_SESSION['password']]);
     */

    function getRowCount($sql, $a) {
        global $DB;
        $exec = FALSE;
        if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->RowCount())
            ;
        return $exec;
    }

    /* getRowCount показывает количество строк в запросе. Результат выдается простым числовым значением.
      Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах. Если значение не найдено, то выдает пустой массив: Array()
      Использовать так: $a = $PDO->getRowCount("SELECT permission FROM users WHERE login=? AND password=?", [$_SESSION['login'],$_SESSION['password']]);
     */

    function selectPrepare($sql, $a) {
        global $DB;
        $exec = FALSE;
        if ($exec = $DB->prepare($sql) AND $exec->execute($a) AND $exec = $exec->fetchAll() AND $exec = $exec[0][0])
            ;
        return $exec;
    }

    /* selectPrepare показывает значение ячейки (не массив). Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
      Если значение не найдено, то выдает пустой массив: Array()
      Использовать так: $a = $PDO->selectPrepare("SELECT permission FROM users WHERE login=? AND password=?", [$_SESSION['login'],$_SESSION['password']]);
     */

    function insertPrepare($sql, $a) {
        global $DB;
        $exec = FALSE;
        if ($exec = $DB->prepare($sql) AND $exec->execute($a))
            ;
        return $exec;
    }

    /* insertPrepare служит для INSERT INTO, DELETE и UPDATE. Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых записях.
      Если значения нет, то передает пустой массив: Array()
      Использовать так:
      $PDO->insertPrepare("INSERT INTO emkt_table SET login=?, password=?", [$_SESSION['login'], $_SESSION['password']]); - создает новую строку
      $PDO->insertPrepare("UPDATE emkt_table SET login=?, password=? WHERE id=?", [$_SESSION['login'], $_SESSION['password'], $id]); - обновляет строку с конкретным id
      $PDO->insertPrepare("DELETE FROM emkt_table WHERE id=?", [$id]); - удаляет строку с конкретным id
      Также можно применять для SELECT.
     */
}

?>
