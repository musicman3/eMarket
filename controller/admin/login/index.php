<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

session_start();

if ($VALID->inGET('logout') == 'ok') {
    session_destroy();    //удаляем текущую сессию
    header('Location: /controller/admin/login/');    //перенаправляем на login.php
}

if ($VALID->inPOST('autorize') == 'ok') {
    //Ищем авторизованного администратора
    $HASH = $PDO->selectPrepare("SELECT password FROM " . TABLE_ADMINISTRATORS . " WHERE login=?", [$VALID->inPOST('login')]);
    if (!password_verify($VALID->inPOST('pass'), $HASH)) {    //Если проверка не удалась:
        session_destroy();
        session_start();
        $_SESSION['default_language'] = DEFAULT_LANGUAGE;
        $_SESSION['login_error'] = lang('login_error');
    } else {
        $_SESSION['login'] = $VALID->inPOST('login');
        $_SESSION['pass'] = $HASH;
        header('Location: /controller/admin/index.php');    // else: редирект на index.php
    }
}

// если логин или пароль не верные, то готовим уведомление
if (isset($_SESSION['login_error']) == TRUE) {
    $login_error = $_SESSION['login_error'];
    session_destroy();
} else {
    $login_error = '';
}

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */

?>