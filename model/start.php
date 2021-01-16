<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$TIME_START = microtime(1);
//ENABLE LOG
error_reporting(-1);
ini_set('error_log', __DIR__ . '/work/errors.log');

//AUTOLOAD FOR CLASSES
require_once('vendor/autoload.php');

\eMarket\Core\Debug::$TIME_START = $TIME_START;
unset($TIME_START);

//AUTOLOAD FOR FUNCTION
foreach (\eMarket\Core\Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}

//AUTOLOAD FOR MODULES CLASSES
foreach (\eMarket\Core\Tree::modulesClasses() as $path) {
    require_once($path);
}

// Config file and etc.
if (\eMarket\Core\Settings::path() == 'admin' OR \eMarket\Core\Settings::path() == 'catalog') {
    require_once('configure/configure.php');
}
//Autorize
\eMarket\Core\Autorize::init();
//Languages
\eMarket\Core\Lang::init();
//JS Handler
\eMarket\Core\Settings::jsHandler();
?>