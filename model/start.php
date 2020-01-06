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

//АВТОЗАГРУЗКА БАЗОВЫХ КЛАССОВ
require_once('vendor/autoload.php');

//АВТОЗАГРУЗКА БАЗОВЫХ ФУНКЦИЙ
foreach (\eMarket\Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}

//АВТОЗАГРУЗКА КЛАССОВ МОДУЛЕЙ
foreach (\eMarket\Tree::modulesClasses() as $path) {
    require_once($path);
}

//Если это панель администратора
if (\eMarket\Set::path() == 'admin') {
    require_once('configure/configure.php');

    // Загружаем авторизацию Административной части
    if (\eMarket\Valid::inGET('route') != 'login') {
        $TOKEN = \eMarket\Autorize::sessionAdmin();
    }
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

    // Инициализация корзины
    \eMarket\Cart::init();
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