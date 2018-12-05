<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 

/**
 * Функция для соединения с БД
 * @param строка $a маркер
 * @return объект
 */
function connect($a = null) {
    static $connect = null;

    $SET = new \eMarket\Core\Set;

    if (isset($a) && $a == 'end') {
        return $connect;
    }

    if (!isset($connect) && defined('DB_TYPE') && defined('DB_SERVER') && defined('DB_NAME') && defined('DB_USERNAME') && defined('DB_PASSWORD')) {

        try {
            $connect = new PDO(DB_TYPE . ':host=' . DB_SERVER . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        } catch (PDOException $error) {
            // Если ошибка соединения с БД в инсталляторе, то переадресуем на страницу ошибки
            if ($SET->path() == 'install') {
                header('Location: /controller/install/error.php?server_db_error=true&error_message=' . $error->getMessage());
            } else {
                //Выводим на экран, если не в инсталляторе
                print_r($error->getMessage());
            }
        }
        $connect->exec("set names utf8mb4");
    }

    return $connect;
}

?>