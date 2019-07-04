<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

session_start();

if ($VALID->inGET('logout') == 'ok') {
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
if (isset($_SESSION['login_error']) == TRUE) {
    $login_error = $_SESSION['login_error'];
    //удаляем текущую сессию
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
} else {
    $login_error = '';
}

if ($VALID->inPOST('install') == 'ok') {
    session_destroy();    //удаляем текущую сессию
    session_start();
}

if ($VALID->inPOST('autorize') == 'ok') {
    //Ищем авторизованного администратора
    $HASH = $PDO->selectPrepare("SELECT password FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [$VALID->inPOST('login')]);
    if (!password_verify($VALID->inPOST('pass'), $HASH)) {    //Если проверка не удалась:
        //удаляем текущую сессию
        unset($_SESSION['login']);
        unset($_SESSION['pass']);
        $_SESSION['default_language'] = DEFAULT_LANGUAGE;
        $_SESSION['login_error'] = lang('login_error');
    } else {
        $_SESSION['login'] = $VALID->inPOST('login');
        $_SESSION['pass'] = $HASH;
        header('Location: ?route=dashboard');    // Если все успешно, то редирект в административную часть
    }
}
?>