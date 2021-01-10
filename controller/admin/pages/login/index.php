<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

session_start();

if (\eMarket\Valid::inGET('logout') == 'ok') {
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
    header('Location: ?route=login');
}

if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    if (isset($_SESSION['session_page'])) {
        $session_page = $_SESSION['session_page'];
        unset($_SESSION['session_page']);
        header('Location: ' . $session_page);
    } else {
        header('Location: ?route=dashboard'); 
    }
}

if (isset($_SESSION['login_error']) == TRUE && \eMarket\Valid::inPOST('login') && \eMarket\Valid::inPOST('pass')) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login']);
    unset($_SESSION['pass']);
} else {
    $login_error = '';
}

if (\eMarket\Valid::inPOST('install') == 'ok') {
    session_destroy();
    session_start();
}

if (\eMarket\Valid::inPOST('autorize') == 'ok') {
    $HASH = \eMarket\Pdo::selectPrepare("SELECT password FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [\eMarket\Valid::inPOST('login')]);
    if (!password_verify(\eMarket\Valid::inPOST('pass'), $HASH)) {
        unset($_SESSION['login']);
        unset($_SESSION['pass']);
        $_SESSION['default_language'] = \eMarket\Settings::basicSettings('primary_language');
        $_SESSION['login_error'] = lang('login_error');
    } else {
        $_SESSION['login'] = \eMarket\Valid::inPOST('login');
        $_SESSION['pass'] = $HASH;
        if (isset($_SESSION['session_page'])) {
            $session_page = $_SESSION['session_page'];
            unset($_SESSION['session_page']);
            header('Location: ' . $session_page);
        } else {
            header('Location: ?route=dashboard');
        }
    }
}
