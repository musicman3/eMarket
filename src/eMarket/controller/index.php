<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);
error_reporting(-1);

// Start debug stopwatch
$eMarketDebugStopwatch = microtime(true);

// PSR-4 Autoload
require_once(getenv('DOCUMENT_ROOT') . '/vendor/autoload.php');

use eMarket\Core\{
    Authorize,
    Debug,
    Lang,
    Messages,
    Pdo,
    Routing,
    Settings,
    Tree
};

// Load Debug stopwatch
Debug::$debug_stopwatch = $eMarketDebugStopwatch;

// Settings init
Settings::init();

// Autoload for function
foreach (Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/library/php/functions/') as $path) {
    require_once($path);
}

// Autoload for modules classes
foreach (Tree::modulesClasses() as $path) {
    require_once($path);
}

// Load Monolog logging
Messages::monologErrorHandler();

// Add Config file
if (Settings::path() != 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php');
}

// Load Autorize
new Authorize();

// Load Languages
new Lang();

// Routing
$eMarketRouting = new Routing();
$eMarketPage = $eMarketRouting->page();
$eMarket = new $eMarketPage();
Settings::loadPage($eMarket);

if ($eMarketRouting->constructor()) {
    require_once($eMarketRouting->constructor());
}

// Close DB connect
Pdo::connect('end');
