<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// ЕСЛИ В АДМИНИСТРАТИВНОЙ ПАНЕЛИ
if ($PATH == 'admin' && $TITLE_DIR != 'verify') {

    session_start();
    $login = null;
    $pass = null;

    if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
        $login = $_SESSION['login'];
        $pass = $_SESSION['pass'];
    }

    $verify = $PDO->getRowCount("SELECT * FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$login, $pass]);

    if ($verify != 1) { //NO USER
        header('Location: /controller/admin/verify/login.php'); // переадресация на LOGIN.PHP
    } else {
        $TOKEN = hash(HASH_METHOD, $_SESSION['login'] . $_SESSION['pass']); // создаем токен для ajax и пр.
    }
}

// ЕСЛИ В КАТАЛОГЕ
if ($PATH == 'catalog' && $TITLE_DIR != 'verify') {

    session_start();
    $login = null;
    $pass = null;

    if (isset($_SESSION['login']) && isset($_SESSION['pass'])) {
        $login = $_SESSION['login'];
        $pass = $_SESSION['pass'];
    }

    $verify = $PDO->getRowCount("SELECT * FROM " . TABLE_ADMINISTRATORS . " WHERE login=? AND password=?", [$login, $pass]);

    if ($verify != 1) { //NO USER
        header('Location: /controller/admin/verify/login.php'); // переадресация на LOGIN.PHP
    } else {
        $TOKEN = hash(HASH_METHOD, $_SESSION['login'] . $_SESSION['pass']); // создаем токен для ajax и пр.
    }
}

?>