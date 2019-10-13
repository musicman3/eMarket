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
if ($SET->path() == 'admin') {
    require_once('configure/configure.php');
    // Загружаем авторизацию Административной части
    if ($VALID->inGET('route') != 'login') {
        $TOKEN = $AUTORIZE->sessionAdmin();
    }
    // Данные по текущей валюте
    $CURRENCIES = $SET->currencyDefault();
}

// Если это каталог
if ($SET->path() == 'catalog') {
    require_once('configure/configure.php');

    // Загружаем авторизацию Каталога
    if ($AUTORIZE->sessionCatalog() == TRUE) {
        $CUSTOMER = $PDO->getColAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    } else {
        $CUSTOMER = FALSE;
    }
    // Данные по текущей валюте
    $CURRENCIES = $SET->currencyDefault();

    // Инициализация корзины
    $CART->init();
    
    // Инициализация ECB
    $ecb_init = $ECB->init($_SESSION['cart'], $CURRENCIES);
}

// Считаем количество языков
$LANG_COUNT = count(lang('#lang_all'));

//unset($_SESSION['cart']);
//$DEBUG->trace($ecb_init);
?>