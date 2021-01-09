<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$TIME_START = microtime(1);
//ПОДКЛЮЧАЕМ ЛОГ / ENABLE LOG
error_reporting(-1);
ini_set('error_log', __DIR__ . '/work/errors.log');

//АВТОЗАГРУЗКА КЛАССОВ / AUTOLOAD FOR CLASSES
require_once('vendor/autoload.php');

\eMarket\Debug::$TIME_START = $TIME_START;
unset($TIME_START);

//АВТОЗАГРУЗКА ФУНКЦИЙ / AUTOLOAD FOR FUNCTION
foreach (\eMarket\Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}

//АВТОЗАГРУЗКА КЛАССОВ МОДУЛЕЙ / AUTOLOAD FOR MODULES CLASSES
foreach (\eMarket\Tree::modulesClasses() as $path) {
    require_once($path);
}

// Файл конфигурации и др. / config file and etc.
if (\eMarket\Settings::path() == 'admin' OR \eMarket\Settings::path() == 'catalog') {
    require_once('configure/configure.php');
}
//Авторизация / Autorize
\eMarket\Autorize::init();
//Языки / Languages
\eMarket\Lang::init();
//JS Handler
\eMarket\Settings::jsHandler();
?>