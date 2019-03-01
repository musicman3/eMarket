<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
error_reporting(-1);

$tstart = microtime(1); // Засекаем начальное время 
// Автозагрузка
require_once('cluster.php');

// Если это инсталлятор, то не грузим файл конфигурации
if ($SET->path() != 'install') {
    require_once('configure/configure.php');
}

// Загружаем авторизацию Административной части
$TOKEN = $AUTORIZE->sessionAdmin();

// Загружаем авторизацию Каталога
$AUTORIZE->sessionCatalog();

// Загружаем языковой роутер
require_once('router_lang.php');
// Считаем количество языков
$LANG_COUNT = count(lang('#lang_all'));
// Данные по текущей валюте
if ($SET->path() != 'install') {
    $CURRENCIES = $PDO->getColRow("SELECT * FROM " . TABLE_CURRENCIES . " WHERE language=? AND default_value=?", [lang('#lang_all')[0], 1])[0];
}

?>