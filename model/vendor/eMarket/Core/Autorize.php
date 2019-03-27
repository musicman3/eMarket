<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

/**
 * Класс для авторизации пользователей
 *
 * @package Autorize
 * @author eMarket
 * 
 */
class Autorize {

    /**
     * Авторизация сессиями для Административной панели
     *
     * @return string $str ($TOKEN)
     */
    public function sessionAdmin() {

        $SET = new \eMarket\Core\Set;
        $PDO = new \eMarket\Core\Pdo;
        // ЕСЛИ В АДМИНИСТРАТИВНОЙ ПАНЕЛИ
        if ($SET->path() == 'admin' && $SET->titleDir() != 'login') {

            session_start();

            if (isset($_SESSION['session_start']) && (time() - $_SESSION['session_start']) / 60 > $SET->sessionExprTime()) { // Если истекло время сеанса
                session_destroy();
                header('Location: ?route=login'); // переадресация на LOGIN
            }
            $_SESSION['session_start'] = time();

            if (!isset($_SESSION['login'])) { // Если нет пользователя
                session_destroy();
                header('Location: ?route=login'); // переадресация на LOGIN
            } else {
                $TOKEN = $_SESSION['pass']; // создаем токен для ajax и пр.
                //Язык авторизованного администратора
                $_SESSION['DEFAULT_LANGUAGE'] = $PDO->selectPrepare("SELECT language FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$_SESSION['login'], $_SESSION['pass']]);

                return $TOKEN;
            }
        }
    }

    /**
     * Авторизация сессиями для Каталога
     *
     * @return string $str ($TOKEN)
     */
    public function sessionCatalog() {

        $SET = new \eMarket\Core\Set;
        if ($SET->path() == 'catalog') {

            session_start();

            if (!isset($_SESSION['login_user'])) { // Если нет пользователя
            } else {
                $TOKEN_CATALOG = $_SESSION['pass']; // создаем токен для ajax и пр.
                //Язык авторизованного пользователя
                $_SESSION['DEFAULT_LANGUAGE'] = DEFAULT_LANGUAGE;

                return $TOKEN_CATALOG;
            }
        }
    }

    /**
     * Хэширование пароля
     *
     * @param string $password (входящий пароль)
     * @return string $password_hash (хэшированный пароль)
     */
    public function passwordHash($password) {

        if (HASH_METHOD == 'PASSWORD_DEFAULT') {
            $options = ['cost' => 10]; // Уровень сложности
            $METHOD = PASSWORD_DEFAULT;
        }
        if (HASH_METHOD == 'PASSWORD_BCRYPT') {
            $options = ['cost' => 10]; // Уровень сложности
            $METHOD = PASSWORD_BCRYPT;
        }
        if (HASH_METHOD == 'PASSWORD_ARGON2I') {
            $options = ['time_cost' => 2]; // Максимум в сек. на вычисление хэша
            $METHOD = PASSWORD_ARGON2I;
        }
        $password_hash = password_hash($password, $METHOD, $options); // Хэшируем пароль
        return $password_hash;
    }

}

?>