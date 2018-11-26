<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
error_reporting(-1);

$tstart = microtime(1); // Засекаем начальное время 

require_once('autoloader.php');

require_once('configure/basic_variables.php');

//Если это инсталлятор, то не грузим файл
if ($PATH != 'install') {
    require_once('configure/configure.php');
}

require_once('configure/connect.php');

require_once('session_autorize.php');

require_once('router_lang.php');

//Если это инсталлятор, то не грузим файл
if ($PATH != 'install') {
    require_once('settings.php');
}
?>