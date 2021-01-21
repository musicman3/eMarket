<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$TIME_START = microtime(1);
//ENABLE LOG
error_reporting(-1);
ini_set('error_log', __DIR__ . '/storage/logs/errors.log');

//AUTOLOAD FOR CLASSES
require_once('vendor/autoload.php');

use \eMarket\Core\{
    Autorize,
    Debug,
    Lang,
    Settings,
    Tree
};

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
if (Settings::path() == 'admin' OR Settings::path() == 'catalog') {
    require_once('storage/configure/configure.php');
}
//Autorize
Autorize::init();
//Languages
Lang::init();
//JS Handler
Settings::jsHandler();
