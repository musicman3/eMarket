<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

session_start();

if (\eMarket\Valid::inGET('logout') == 'ok') {
    //удаляем текущую сессию
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
    header('Location: ?route=login');    //перенаправляем на авторизацию
}

if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    //Ищем авторизованного администратора
    if (isset($_SESSION['session_page'])) {
        $session_page = $_SESSION['session_page'];
        unset($_SESSION['session_page']);
        header('Location: ' . $session_page);
    } else {
        header('Location: ?route=dashboard');    // Если все успешно, то редирект в административную часть
    }
}

// если логин или пароль не верные, то готовим уведомление
if (isset($_SESSION['login_error']) == TRUE && \eMarket\Valid::inPOST('login') && \eMarket\Valid::inPOST('pass')) {
    $login_error = $_SESSION['login_error'];
    //удаляем текущую сессию
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
} else {
    $login_error = '';
}

if (\eMarket\Valid::inPOST('install') == 'ok') {
    session_destroy();    //удаляем текущую сессию
    session_start();
}

if (\eMarket\Valid::inPOST('autorize') == 'ok') {
    //Ищем авторизованного администратора
    $HASH = \eMarket\Pdo::selectPrepare("SELECT password FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [\eMarket\Valid::inPOST('login')]);
    if (!password_verify(\eMarket\Valid::inPOST('pass'), $HASH)) {    //Если проверка не удалась:
        //удаляем текущую сессию
        unset($_SESSION['login']);
        unset($_SESSION['pass']);
        $_SESSION['default_language'] = DEFAULT_LANGUAGE;
        $_SESSION['login_error'] = lang('login_error');
    } else {
        $_SESSION['login'] = \eMarket\Valid::inPOST('login');
        $_SESSION['pass'] = $HASH;
        if (isset($_SESSION['session_page'])) {
            $session_page = $_SESSION['session_page'];
            unset($_SESSION['session_page']);
            header('Location: ' . $session_page);
        } else {
            header('Location: ?route=dashboard');    // Если все успешно, то редирект в административную часть
        }
    }
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>