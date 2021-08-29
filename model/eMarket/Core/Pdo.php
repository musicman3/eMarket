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
            } catch (\PDOException $error) {
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
     * @param array $param (parameter for execute)
     * @return bool|string|array
     */
    public static function getCell($sql, $param) {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchColumn();
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * getColRow
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return bool|array
     */
    public static function getColRow($sql, $param) {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_NUM);
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * getColCount
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return bool|int|array
     */
    public static function getColCount($sql, $param) {
        
        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->ColumnCount();
        }
        return $result;
    }

    /**
     * getRowCount
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return bool|int|array
     */
    public static function getRowCount($sql, $param) {
        
        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->RowCount();
        }
        return $result;
    }

    /**
     * Action (INSERT INTO, DELETE and UPDATE)
     *
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return bool|array
     */
    public static function action($sql, $param = null) {

        $exec = self::connect()->prepare($sql);
        $exec->execute($param);

        return $exec;
    }

    /**
     * getColAssoc
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return bool|array
     */
    public static function getColAssoc($sql, $param) {
        
        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_ASSOC);
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * getObj
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return bool|array
     */
    public static function getObj($sql, $param) {
        
        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_OBJ);
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
