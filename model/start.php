<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//ВРЕМЯ ФОРМИРОВАНИЯ СТРАНИЦЫ
$TIME_START = microtime(1);
//ПОДКЛЮЧАЕМ ЛОГ
error_reporting(-1);
ini_set('error_log', __DIR__ . '/work/errors.log');

//АВТОЗАГРУЗКА БАЗОВЫХ КЛАССОВ
require_once('vendor/autoload.php');

\eMarket\Debug::$TIME_START = $TIME_START;

//АВТОЗАГРУЗКА БАЗОВЫХ ФУНКЦИЙ
foreach (\eMarket\Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}

//АВТОЗАГРУЗКА КЛАССОВ МОДУЛЕЙ
foreach (\eMarket\Tree::modulesClasses() as $path) {
    require_once($path);
}

//Если это панель администратора
if (\eMarket\Set::path() == 'admin' OR \eMarket\Set::path() == 'catalog') {
    require_once('configure/configure.php');
}

\eMarket\Autorize::init();

\eMarket\Lang::init();

?>