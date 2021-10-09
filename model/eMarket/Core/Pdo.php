<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Core;

use eMarket\Core\{
    Func,
    Settings
};

/**
 * PDO
 *
 * @package Core
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
final class Pdo {

    public static $query_count = 0;
    private static $connect = null;

    /**
     * Conecting to DB
     * @param string $marker Marker
     * @return object PDO object
     */
    public static function connect(?string $marker = null): ?object {

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
                    exit;
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
    public static function dbInstall(string $path): void {

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
     * @return mixed data
     */
    public static function getExec(string $sql): mixed {

        $result = self::connect()->exec($sql);
        return $result;
    }

    /**
     * Get value
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getValue(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchColumn();
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * Get an indexed array 
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getIndex(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_NUM);
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * Get associated array 
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getAssoc(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_ASSOC);
        }
        return Func::outputDataFiltering($result);
    }

    /**
     * Get object
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getObj(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->fetchAll(\PDO :: FETCH_OBJ);
        }
        return $result;
    }

    /**
     * Count the number of columns 
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getColCount(string $sql, array $param): mixed {

        $result = FALSE;
        $exec = self::connect()->prepare($sql);
        if ($exec && $exec->execute($param)) {
            $result = $exec->ColumnCount();
        }
        return $result;
    }

    /**
     * Count the number of rows 
     * 
     * @param string $sql SQL query
     * @param array $param (parameter for execute)
     * @return mixed
     */
    public static function getRowCount(string $sql, array $param): mixed {

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
     * @return mixed
     */
    public static function action(string $sql, ?array $param = null): mixed {

        $exec = self::connect()->prepare($sql);
        $exec->execute($param);

        return $exec;
    }

    /**
     * lastInsertId
     * 
     * @return int|string
     */
    public static function lastInsertId(): int|string {

        $result = self::connect()->lastInsertId();
        return $result;
    }

}
