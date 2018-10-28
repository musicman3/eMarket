<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/model/autoloader_class.php');

//REQUIRE CONFIGURE.PHP
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/configure/configure.php');

//REQUIRE CONNECT.PHP
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/configure/connect.php');

//REQUIRE router_lang.PHP
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/router_lang.php');

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
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/connect_end.php');

?>