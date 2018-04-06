<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);
session_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/router_class.php');
//LOAD CONFIGURE.PHP
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/configure/configure.php');
//LOAD LANGUAGE
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/router_lang.php');


// если логин или пароль не верные, то готовим уведомление
if (isset($_SESSION['login_error']) == TRUE) {
    $login_error = $_SESSION['login_error'];
    session_destroy();
} else {
    $login_error = '';
}

// если форма не заполнена, то выводим ее
if ($VALID->inPOST('ok') == FALSE) {

    require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/html_start.php');

    //LOAD TEMPLATE
    require_once($VIEW->Routing());

    require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/html_end.php');
}

?>
</body>
</html>