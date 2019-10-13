<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
error_reporting(-1);
ini_set('error_log', __DIR__ . '/work/errors.log');

$TIME_START = microtime(1); // Засекаем начальное время 
//
// Автозагрузка
require_once('cluster.php');

// Загружаем языковой роутер
require_once('router_lang.php');

//Если это панель администратора
if (\eMarket\Core\Set::path() == 'admin') {
    require_once('configure/configure.php');
    // Загружаем авторизацию Административной части
    if (\eMarket\Core\Valid::inGET('route') != 'login') {
        $TOKEN = \eMarket\Core\Autorize::sessionAdmin();
    }
    // Данные по текущей валюте
    $CURRENCIES = \eMarket\Core\Set::currencyDefault();
}

// Если это каталог
if (\eMarket\Core\Set::path() == 'catalog') {
    require_once('configure/configure.php');

    // Загружаем авторизацию Каталога
    if (\eMarket\Core\Autorize::sessionCatalog() == TRUE) {
        $CUSTOMER = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    } else {
        $CUSTOMER = FALSE;
    }
    // Данные по текущей валюте
    $CURRENCIES = \eMarket\Core\Set::currencyDefault();

    // Инициализация корзины
    \eMarket\Other\Cart::init();
    
    // Инициализация ECB
    $ecb_init = \eMarket\Core\Ecb::init($_SESSION['cart'], $CURRENCIES);
}

// Считаем количество языков
$LANG_COUNT = count(lang('#lang_all'));

//unset($_SESSION['cart']);
//\eMarket\Other\Debug::trace($ecb_init);
?>