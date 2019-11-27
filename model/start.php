<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
//ПОДКЛЮЧАЕМ ЛОГ
error_reporting(-1);
ini_set('error_log', __DIR__ . '/work/errors.log');
//ВРЕМЯ ФОРМИРОВАНИЯ СТРАНИЦЫ
$TIME_START = microtime(1);

//АВТОЗАГРУЗКА КЛАССОВ
require_once('vendor/autoload.php');

//АВТОЗАГРУЗКА ФУНКЦИЙ
foreach (\eMarket\Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}

//Если это панель администратора
if (\eMarket\Set::path() == 'admin') {
    require_once('configure/configure.php');
    
    // Загружаем авторизацию Административной части
    if (\eMarket\Valid::inGET('route') != 'login') {
        $TOKEN = \eMarket\Autorize::sessionAdmin();
    }
    // Данные по текущей валюте
    $CURRENCIES = \eMarket\Set::currencyDefault();
}

// Если это каталог
if (\eMarket\Set::path() == 'catalog') {
    require_once('configure/configure.php');
    
    // Загружаем авторизацию Каталога
    if (\eMarket\Autorize::sessionCatalog() == TRUE) {
        $CUSTOMER = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_CUSTOMERS . " WHERE email=?", [$_SESSION['email_customer']])[0];
    } else {
        $CUSTOMER = FALSE;
    }
    // Данные по текущей валюте
    $CURRENCIES = \eMarket\Set::currencyDefault();

    // Инициализация корзины
    \eMarket\Cart::init();

    // Инициализация ECB
    //$product_sales = [['id' => '1', 'product_id' =>'1', 'sale' =>'5'],['id' => '2', 'product_id' =>'1', 'sale' =>'25'],['id' => '3', 'product_id' =>'2', 'sale' =>'15']];
    //$ecb_init = \eMarket\Ecb::init($_SESSION['cart'], $CURRENCIES, $product_sales);
    //\eMarket\Debug::trace($ecb_init);
}

// Загружаем языковой роутер
require_once('router_lang.php');

//Устанавливаем локаль
setlocale(LC_ALL, lang('language_locale'));

// Считаем количество языков
$LANG_COUNT = count(lang('#lang_all'));

//unset($_SESSION['cart']);
//\eMarket\Debug::trace($_SESSION['cart']);
?>