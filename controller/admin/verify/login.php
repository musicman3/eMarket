<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);
session_start();

//AUTOLOADER
require_once(getenv('DOCUMENT_ROOT') . '/model/autoloader.php');

//LOAD CONFIGURE
require_once(getenv('DOCUMENT_ROOT') . '/model/configure/configure.php');

//LOAD BASED_VARIABLES
require_once(ROOT . '/model/configure/based_variables.php');

//LOAD LANGUAGE
require_once(ROOT . '/model/router_lang.php');

// если авторизован, редирект в админку
if (isset($_SESSION['login']) == TRUE) {    //if user true:
    header('Location: /controller/admin/index.php');    // redirect to index.php
}

// если логин или пароль не верные, то готовим уведомление
if (isset($_SESSION['login_error']) == TRUE) {
    $login_error = $_SESSION['login_error'];
    session_destroy();
} else {
    $login_error = '';
}

// если форма не заполнена, то выводим ее
if ($VALID->inPOST('ok') == FALSE) {

    require_once(ROOT . '/model/htmstart.php');

    //LOAD TEMPLATE
    require_once($VIEW->Routing());

    require_once(ROOT . '/model/html_end.php');
}

?>
</body>
</html>