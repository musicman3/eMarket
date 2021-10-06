<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);
error_reporting(-1);

$TIME_START = microtime(true);

//AUTOLOAD FOR CLASSES
require_once(getenv('DOCUMENT_ROOT') . '/vendor/autoload.php');

use eMarket\Core\{
    Authorize,
    Debug,
    Lang,
    Messages,
    Settings,
    Tree
};

// MONOLOG LOGGING
Messages::monologErrorHandler();

//DEBUG
Debug::$time_start = $TIME_START;
unset($TIME_START);

//AUTOLOAD FOR FUNCTION
foreach (Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/library/php/functions/') as $path) {
    require_once($path);
}

//AUTOLOAD FOR MODULES CLASSES
foreach (Tree::modulesClasses() as $path) {
    require_once($path);
}

// Config file and etc.
if (Settings::path() != 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php');
}
//Authorize
new Authorize();
//Languages
new Lang();
//JS Handler
Settings::jsHandler();
