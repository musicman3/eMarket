<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// ЕСЛИ В АДМИНИСТРАТИВНОЙ ПАНЕЛИ
if ($SET->path() == 'admin' && $SET->titleDir() != 'login') {

    session_start();
    
    if (isset($_SESSION['session_start']) && (time() - $_SESSION['session_start']) / 60 > $SET->sessionExprTime()) { // Если истекло время сеанса
        session_destroy();
        header('Location: /controller/admin/login/'); // переадресация на LOGIN
    }
        $_SESSION['session_start'] = time();


    $login = null;
    $pass = null;

    if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
        $login = $_SESSION['login'];
        $pass = $_SESSION['pass'];
    }

    $verify = $PDO->getRowCount("SELECT * FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$login, $pass]);

    if ($verify != 1) { // Если нет пользователя
        session_destroy();
        header('Location: /controller/admin/login/'); // переадресация на LOGIN
    } else {
        $TOKEN = hash(HASH_METHOD, $login . $pass); // создаем токен для ajax и пр.
        //Язык авторизованного администратора
        $DEFAULT_LANGUAGE = $PDO->selectPrepare("SELECT language FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$login, $pass]);
    }
}

// ЕСЛИ В КАТАЛОГЕ
if ($SET->path() == 'catalog' && $SET->titleDir() != 'login') {

    session_start();
    $login = null;
    $pass = null;

    if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
        $login = $_SESSION['login'];
        $pass = $_SESSION['pass'];
    }

    $verify = $PDO->getRowCount("SELECT * FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$login, $pass]);

    if ($verify != 1) { //NO USER
        header('Location: /controller/admin/login/'); // переадресация на LOGIN
    } else {
        $TOKEN = hash(HASH_METHOD, $login . $pass); // создаем токен для ajax и пр.
        //Язык авторизованного пользователя
        $DEFAULT_LANGUAGE = DEFAULT_LANGUAGE;
    }
}

?>