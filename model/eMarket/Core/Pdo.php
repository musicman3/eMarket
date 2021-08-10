<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

use eMarket\Core\{
    Func,
    Settings
};

/**
 * PDO
 *
 * @package Pdo
 * @author eMarket
 * 
 */
final class Pdo {

    public static $query_count = 0;
    private static $connect = null;

    /**
     * Conecting to DB
     * @param string $marker Marker
     * @return object
     */
    public static function connect($marker = null) {

        self::$query_count++;

        if ($marker == 'end') {
            self::$connect = null;
            return self::$connect;
        }

        if (self::$connect == null && defined('DB_TYPE') && defined('DB_SERVER') && defined('DB_NAME') && defined('DB_USERNAME') && defined('DB_PASSWORD')) {

            try {
                self::$connect = new \PDO(DB_TYPE . ':host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING, \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"]);
            } catch (PDOException $error) {
                if (Settings::path() == 'install') {
                    header('Location: /controller/install/error.php?server_db_error=true&error_message=' . $error->getMessage());
                } else {
                    print_r($error->getMessage());
                }
            }
        }

        return self::$connect;
    }

    /**
     * Install DB-file
     *
     * @param string $path Path to DB
     */
    public static function dbInstall($path) {

        $file_name = $path . DB_TYPE . '.sql';

        $buffer = str_replace('emkt_', DB_PREFIX, implode(file($file_name)));

        if (DB_FAMILY == 'myisam') {
            $buffer = str_ireplace('ENGINE=InnoDB', 'ENGINE=MyISAM', $buffer);
        }

        self::getExec($buffer);
    }

    /**
     * getQuery instead self::connect()->query()
     *
     * @param string $sql SQL query
     * @return data
     */
    public static function getQuery($sql) {

        $result = self::connect()->query($sql);
        return $result;
    }

    /**
     * getExec instead self::connect()->exec()
     *
     * @param string $sql SQL query
     * @return data
     */
    public static function getExec($sql) {

        $result = self::connect()->exec($sql);
        return $result;
    }

    /**
     * getCell
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|string|array
     */
    public static function getCell($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $value = $exec->fetch(\PDO :: FETCH_NUM)
                AND $result = $value[0]) {
            
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * getColRow
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|array
     */
    public static function getColRow($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchAll(\PDO :: FETCH_NUM)) {
            
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * getCol
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|array
     */
    public static function getCol($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchAll(\PDO :: FETCH_COLUMN)) {
            
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * getRow 
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|array
     */
    public static function getRow($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchAll(\PDO :: FETCH_NUM)) {
            
        }
        return Func::outputDataFiltering($result)[0];
    }

    /**
     * getCellFalse
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|array
     */
    public static function getCellFalse($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchColumn()) {
            
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * getColCount
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|int|array
     */
    public static function getColCount($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->ColumnCount()) {
            
        }
        return $result;
    }

    /**
     * getRowCount
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|int|array
     */
    public static function getRowCount($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->RowCount()) {
            
        }
        return $result;
    }

    /**
     * selectPrepare
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|string|array
     */
    public static function selectPrepare($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $value = $exec->fetchAll()
                AND $result = $value[0][0]) {
            
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * inPrepare (INSERT INTO, DELETE and UPDATE)
     *
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|array
     */
    public static function action($sql, $a = null) {

        $result = FALSE;
        if ($result = self::connect()->prepare($sql)
                AND $result->execute($a)) {
            
        }
        return $result;
    }

    /**
     * getColAssoc
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|array
     */
    public static function getColAssoc($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchAll(\PDO :: FETCH_ASSOC)) {
            
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * getObj
     * 
     * @param string $sql SQL query
     * @param array $a (parameter for execute($a))
     * @return bool|array
     */
    public static function getObj($sql, $a) {

        $result = FALSE;
        if ($exec = self::connect()->prepare($sql)
                AND $exec->execute($a)
                AND $result = $exec->fetchAll(\PDO :: FETCH_OBJ)) {
            
        }
        return $result;
    }

    /**
     * lastInsertId
     * 
     * @return string
     */
    public static function lastInsertId() {

        $result = self::connect()->lastInsertId();
        return $result;
    }

}
