<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

class Pdo {

    /**
     * Функция для соединения с БД
     * @param строка $a маркер
     * @return объект
     */
    public function connect($a = null) {
        static $connect = null;

        $SET = new \eMarket\Core\Set;

        if (isset($a) && $a == 'end') {
            return $connect;
        }

        if (!isset($connect) && defined('DB_TYPE') && defined('DB_SERVER') && defined('DB_NAME') && defined('DB_USERNAME') && defined('DB_PASSWORD')) {

            try {
                $connect = new \PDO(DB_TYPE . ':host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
            } catch (PDOException $error) {
                // Если ошибка соединения с БД в инсталляторе, то переадресуем на страницу ошибки
                if ($SET->path() == 'install') {
                    header('Location: /controller/install/error.php?server_db_error=true&error_message=' . $error->getMessage());
                } else {
                    //Выводим на экран, если не в инсталляторе
                    print_r($error->getMessage());
                }
            }
        }

        return $connect;
    }

    /**
     * getQuery вместо self::connect()->query()
     *
     * @param строка $sql
     * @return команда MYSQL
     */
    public function getQuery($sql) {

        $result = self::connect()->query($sql);
        return $result;
    }

    /**
     * getExec вместо self::connect()->exec()
     *
     * @param строка $sql
     * @return команда MYSQL
     */
    public function getExec($sql) {

        $result = self::connect()->exec($sql);
        return $result;
    }

    /**
     * getCell для запроса точного значения ячейки.
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
      Если несколько вариантов, удовлетворяющих условию, то выдает только верхний.
      Если значение не найдено, то выдает пустой массив: Array()
      Запрос вида $PDO->getCell("SELECT language FROM table WHERE id=?", ['1']); выдаст конкретное значение russian - НЕ МАССИВ!
      Запрос вида $PDO->getCell("SELECT * FROM table WHERE language=?", ['russian']); выдаст значение первого поля, т.е. номер id.
     * 
     * @param строка $sql
     * @param массив $a
     * @return массив, строка
     */
    public function getCell($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $value = $exec->fetch(\PDO :: FETCH_NUM)
                AND $result = $value[0]) {
            
        }
        return $result;
    }

    /**
     * getColRow для запроса колонок, строк и участков из строк и колонок.
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
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
     * 
     * @param строка $sql
     * @param массив $a
     * @return массив
     */
    public function getColRow($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchAll(\PDO :: FETCH_NUM)) {
            
        }
        return $result;
    }

    /**
     * getCol для запроса колонки в виде одномерного массива.
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
      Если значение не найдено, то выдает пустой массив: Array()
      Если применять в запросе $PDO->getColRow("SELECT name FROM table WHERE language=?", ['russian']) то выдаст все значения колонки id в виде одномерного массива,
      удовлетворяющие условию language='russian'.

      Array
      (
      [0] => Name1
      [1] => Name2
      )
     * 
     * @param строка $sql
     * @param массив $a
     * @return массив
     */
    public function getCol($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchAll(\PDO :: FETCH_COLUMN)) {
            
        }
        return $result;
    }

    /**
     * getCellFalse выдает значение ячейки. Если ячейка не найдена то возвращает FALSE.
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
      Если значение не найдено, то выдает пустой массив: Array()
      Использовать так: $a = $PDO->getCellFalse("SELECT permission FROM users WHERE login=? AND password=?", [$_SESSION['login'],$_SESSION['password']]);
     * 
     * @param строка $sql
     * @param массив $a
     * @return массив
     */
    public function getCellFalse($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchColumn()) {
            
        }
        return $result;
    }

    /**
     * getColCount показывает количество столбцов в запросе. Результат выдается простым числовым значением.
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
      Если значение не найдено, то выдает пустой массив: Array()
      Использовать так: $a = $PDO->getColCount("SELECT permission FROM users WHERE login=? AND password=?", [$_SESSION['login'],$_SESSION['password']]);
     * 
     * @param строка $sql
     * @param массив $a
     * @return массив, int
     */
    public function getColCount($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->ColumnCount()) {
            
        }
        return $result;
    }

    /**
     * getRowCount показывает количество строк в запросе. Результат выдается простым числовым значением.
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
      Если значение не найдено, то выдает пустой массив: Array()
      Использовать так: $a = $PDO->getRowCount("SELECT permission FROM users WHERE login=? AND password=?", [$_SESSION['login'],$_SESSION['password']]);
     * 
     * @param строка $sql
     * @param массив $a
     * @return массив, int
     */
    public function getRowCount($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->RowCount()) {
            
        }
        return $result;
    }

    /**
     * selectPrepare показывает значение ячейки (не массив).
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
      Если значение не найдено, то выдает пустой массив: Array()
      Использовать так: $a = $PDO->selectPrepare("SELECT permission FROM users WHERE login=? AND password=?", [$_SESSION['login'],$_SESSION['password']]);
     * 
     * @param строка $sql
     * @param массив $a
     * @return массив, строка
     */
    public function selectPrepare($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $value = $exec->fetchAll()
                AND $result = $value[0][0]) {
            
        }
        return $result;
    }

    /**
     * inPrepare служит для INSERT INTO, DELETE и UPDATE. 
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
      Если значения нет, то передает пустой массив: Array()
      Использовать так:
      $PDO->inPrepare("INSERT INTO emkt_table SET login=?, password=?", [$_SESSION['login'], $_SESSION['password']]); - создает новую строку
      $PDO->inPrepare("UPDATE emkt_table SET login=?, password=? WHERE id=?", [$_SESSION['login'], $_SESSION['password'], $id]); - обновляет строку с конкретным id
      $PDO->inPrepare("DELETE FROM emkt_table WHERE id=?", [$id]); - удаляет строку с конкретным id
      Также можно применять для SELECT.
     * 
     * @param строка $sql
     * @param массив $a
     * @return команда MYSQL
     */
    public function inPrepare($sql, $a = null) {

        $result = FALSE;
        if ($result = self::connect()->prepare($sql)
                AND $result->execute($a)) {
            
        }
        return $result;
    }

    /**
     * getColAssoc для запроса колонки в виде одномерного массива.
     * Применяется для случаев защиты от SQL-инъекций и при множественных одинаковых запросах.
     * 
     * ПРИМЕР
     *
     * Использовать так: $a = $PDO->getColAssoc("SELECT value, name FROM categories", []);
     * 
      Возвращаем следующую строку в виде массива, индексированного именами столбцов
      Array
      (
      [name] => apple
      [colour] => red
      )
     */
    public function getColAssoc($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchAll(\PDO :: FETCH_ASSOC)) {
            
        }
        return $result;
    }

}

?>
