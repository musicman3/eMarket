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
    Debug,
    Lang,
    Messages,
    Routing,
    Settings,
    Tree
};
use eMarket\Admin\{
    BasicSettings
};
use Cruder\Db;

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

// Add Config file, DB Settings, BasicSettings
if (Settings::path() != 'install') {

    require_once(getenv('DOCUMENT_ROOT') . '/storage/configure/configure.php');
    require_once(getenv('DOCUMENT_ROOT') . '/storage/configure/cruder_config.php');

    // Load BasicSettings
    new BasicSettings();
}

// Routing
$Routing = new Routing();

// Load Languages
new Lang();

// Load Template
if ($Routing->constructor()) {
    require_once($Routing->constructor());
}

// Close DB connect
Db::close();
