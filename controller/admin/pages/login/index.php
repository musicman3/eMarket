<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

session_start();

if (\eMarket\Core\Valid::inGET('logout') == 'ok') {
    //удаляем текущую сессию
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
    header('Location: ?route=login');    //перенаправляем на авторизацию
}

if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    //Ищем авторизованного администратора
    header('Location: ?route=dashboard');    // Если все успешно, то редирект в административную часть
}

// если логин или пароль не верные, то готовим уведомление
if (isset($_SESSION['login_error']) == TRUE && \eMarket\Core\Valid::inPOST('login') && \eMarket\Core\Valid::inPOST('pass')) {
    $login_error = $_SESSION['login_error'];
    //удаляем текущую сессию
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
} else {
    $login_error = '';
}

if (\eMarket\Core\Valid::inPOST('install') == 'ok') {
    session_destroy();    //удаляем текущую сессию
    session_start();
}

if (\eMarket\Core\Valid::inPOST('autorize') == 'ok') {
    //Ищем авторизованного администратора
    $HASH = \eMarket\Core\Pdo::selectPrepare("SELECT password FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [\eMarket\Core\Valid::inPOST('login')]);
    if (!password_verify(\eMarket\Core\Valid::inPOST('pass'), $HASH)) {    //Если проверка не удалась:
        //удаляем текущую сессию
        unset($_SESSION['login']);
        unset($_SESSION['pass']);
        $_SESSION['default_language'] = DEFAULT_LANGUAGE;
        $_SESSION['login_error'] = lang('login_error');
    } else {
        $_SESSION['login'] = \eMarket\Core\Valid::inPOST('login');
        $_SESSION['pass'] = $HASH;
        header('Location: ?route=dashboard');    // Если все успешно, то редирект в административную часть
    }
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>