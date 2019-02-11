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

// НАСТРОЙКИ ПОЗИЦИЙ (ВРЕМЕННО)
$LAYOUT_POS_ARR = [
    '/controller/admin/header.php' => 'header',
    '/controller/admin/footer.php' => 'footer',
    '/controller/catalog/header.php' => 'header',
    '/controller/catalog/footer.php' => 'footer',
    '/controller/catalog/layouts/boxes/categories.php' => 'boxes-left',
    '/controller/catalog/layouts/content/welcome.php' => 'content-center',
    '/controller/catalog/layouts/content/new_products.php' => 'content-center',
    '/controller/catalog/layouts/content/logo_search.php' => 'header',
    '/controller/catalog/layouts/content/breadcrumb.php' => 'header',
    '/controller/catalog/layouts/content/slide_show.php' => 'header',
    '/controller/install/header.php' => 'header',
    '/controller/install/footer.php' => 'footer'
];

$LAYOUT_POS = $VIEW->layoutRoutingFilter($LAYOUT_POS_ARR); // Оставляем в массиве только то, что относится к пути (admin, catalog и т.п.)

?>