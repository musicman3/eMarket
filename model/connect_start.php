<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
if (!isset($CONFIGURE) == 'FALSE') {// МАРКЕР ОТКЛЮЧЕНИЯ НА СТРАНИЦЕ
    require_once('configure/configure.php');
}

if (!isset($AUTOLOADER) == 'FALSE') {// МАРКЕР ОТКЛЮЧЕНИЯ НА СТРАНИЦЕ
    require_once('autoloader.php');
}

if (!isset($CONNECT) == 'FALSE') {// МАРКЕР ОТКЛЮЧЕНИЯ НА СТРАНИЦЕ
    require_once('configure/connect.php');
}

if (!isset($BASED_VARIABLES) == 'FALSE') {// МАРКЕР ОТКЛЮЧЕНИЯ НА СТРАНИЦЕ
    require_once('configure/based_variables.php');
}

if (!isset($ROUTER_LANG) == 'FALSE') {// МАРКЕР ОТКЛЮЧЕНИЯ НА СТРАНИЦЕ
    require_once('router_lang.php');
}

if (!isset($SESSION_AUTORIZE) == 'FALSE') {// МАРКЕР ОТКЛЮЧЕНИЯ НА СТРАНИЦЕ
    require_once('configure/session_autorize.php');
}

?>