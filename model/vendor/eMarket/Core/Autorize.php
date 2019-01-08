<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Core;

class Autorize {

    /**
     * Авторизация сессиями для Административной панели
     *
     * @return строка $str ($TOKEN)
     */
    public function sessionAdmin() {

        $SET = new \eMarket\Core\Set;
        $PDO = new \eMarket\Core\Pdo;
        // ЕСЛИ В АДМИНИСТРАТИВНОЙ ПАНЕЛИ
        if ($SET->path() == 'admin' && $SET->titleDir() != 'login') {

            session_start();

            if (isset($_SESSION['session_start']) && (time() - $_SESSION['session_start']) / 60 > $SET->sessionExprTime()) { // Если истекло время сеанса
                session_destroy();
                header('Location: /controller/admin/login/'); // переадресация на LOGIN
            }
            $_SESSION['session_start'] = time();
            
            if (!isset($_SESSION['login'])) { // Если нет пользователя
                session_destroy();
                header('Location: /controller/admin/login/'); // переадресация на LOGIN
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
     * @return строка $str ($TOKEN)
     */
    public function sessionCatalog() {

        $SET = new \eMarket\Core\Set;
        $PDO = new \eMarket\Core\Pdo;
        if ($SET->path() == 'catalog' && $SET->titleDir() != 'login') {

            session_start();

            if (!isset($_SESSION['login'])) { // Если нет пользователя
                session_destroy();
                header('Location: /controller/admin/login/'); // переадресация на LOGIN
            } else {
                $TOKEN_CATALOG = $_SESSION['pass']; // создаем токен для ajax и пр.
                //Язык авторизованного пользователя
                $_SESSION['DEFAULT_LANGUAGE'] = DEFAULT_LANGUAGE;

                return $TOKEN_CATALOG;
            }
        }
    }

}

?>