<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

//AUTOLOADER
require_once(getenv('DOCUMENT_ROOT') . '/model/autoloader.php');

//LOAD CONFIGURE
require_once(getenv('DOCUMENT_ROOT') . '/model/configure/configure.php');

//LOAD BASED_VARIABLES
require_once(ROOT . '/model/configure/based_variables.php');

//LOAD CONNECT
require_once(ROOT . '/model/configure/connect.php');

//LOAD LANGUAGE
require_once(ROOT . '/model/router_lang.php');

//SESSION = POST FORM
session_start();

$_SESSION['login'] = $VALID->inPOST('login');
$_SESSION['pass'] = hash(HASH_METHOD, $VALID->inPOST('pass'));

//VERIFY USER
$verify = $PDO->getRowCount("SELECT * FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$_SESSION['login'], $_SESSION['pass']]);

//DEFAULT LANGUAGE
$deflang = $PDO->selectPrepare("SELECT language FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$_SESSION['login'], $_SESSION['pass']]);

if ($verify != 1) {    //if user failed:
    session_destroy();
    session_start();

    $_SESSION['default_language'] = $deflang;
    $_SESSION['login_error'] = $lang['login_error'];

    header('Location: /controller/admin/verify/login.php');    // if user failed: redirect to login.php
} else {
    header('Location: /controller/admin/index.php');    // else: redirect to index.php
}

//END CONNECT DATABASE
require_once(ROOT . '/model/connect_end.php');

?>