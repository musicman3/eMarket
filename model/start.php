<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
error_reporting(-1);
ini_set('error_log', ROOT . '/work/errors.log');

$TIME_START = microtime(1); // Засекаем начальное время 
//
// Автозагрузка
require_once('cluster.php');

// Если это инсталлятор, то не грузим файл конфигурации
if ($SET->path() != 'install') {
    require_once('configure/configure.php');
}

// Загружаем авторизацию Административной части
if ($VALID->inGET('route') != 'login') {
    $TOKEN = $AUTORIZE->sessionAdmin();
}
// Загружаем авторизацию Каталога
if ($AUTORIZE->sessionCatalog() == TRUE) {
    $CUSTOMER = $PDO->getColAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
} else {
    $CUSTOMER = FALSE;
}

// Загружаем языковой роутер
require_once('router_lang.php');

// Считаем количество языков
$LANG_COUNT = count(lang('#lang_all'));

// Данные по текущей валюте
if ($SET->path() != 'install') {
    $CURRENCIES = $SET->currencyDefault();
}

// Инициализация корзины
$CART->init();


//unset($_SESSION['cart']);
//$DEBUG->trace($CUSTOMER);

?>