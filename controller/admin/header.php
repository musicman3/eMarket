<?php
// ****** Copyright © 2018 eMarket *****//
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//

error_reporting(-1);

// Структура меню
$level = array();
$menu = array();
$submenu = array();

//СОРТИРОВКА
$menu_market = '0'; //МАГАЗИН
$menu_sales = '1'; // ПРОДАЖИ
$menu_marketing = '2'; //МАРКЕТИНГ
$menu_counterparty = '3'; //КОНТРАГЕНТЫ
$menu_modules = '4'; //МОДУЛИ
$menu_tools = '5'; //ИНСТРУМЕНТЫ
$menu_prefences = '6'; //НАСТРОЙКИ
$menu_help = '7'; //ПОМОЩЬ
$menu_exit = '8'; //ВЫХОД
//МАГАЗИН
$level[$menu_market] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span>Магазин<b class="caret"></b></a>';

$menu[$menu_market][0] = '<a href="/controller/admin/pages/stock/stock.php"><span><img src="/view/default/admin/images/icons/16x16/products.png" /></span> Склад </a>';
$menu[$menu_market][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/manufacturers.png" /></span> Производители </a>';
$menu[$menu_market][2] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/attributes.png" /></span> Атрибуты </a>';
$menu[$menu_market][3] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/date.png" /></span> Ожидаемые </a>';

//ПРОДАЖИ
$level[$menu_sales] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span>Продажи<b class="caret"></b></a>';

$menu[$menu_sales][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/orders.png" /></span> Заказы </a>';
$menu[$menu_sales][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/return.png" /></span> Возвраты </a>';

//МАРКЕТИНГ
$level[$menu_marketing] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span>Маркетинг<b class="caret"></b></a>';

$menu[$menu_marketing][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/specials.png" /></span> Распродажи </a>';
$menu[$menu_marketing][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/feature.png" /></span> Рекомендуемые </a>';
$menu[$menu_marketing][2] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/coupons.png" /></span> Купоны </a>';
$menu[$menu_marketing][3] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/banners.png" /></span> Баннеры </a>';
$menu[$menu_marketing][4] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/email_send.png" /></span> Рассылки </a>';
$menu[$menu_marketing][5] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/article.png" /></span> Статьи </a>';
$menu[$menu_marketing][6] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/reviews.png" /></span> Отзывы </a>';
$menu[$menu_marketing][7] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/chart.png" /></span> Отчеты </a>';

//КОНТРАГЕНТЫ
$level[$menu_counterparty] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span>Контрагенты<b class="caret"></b></a>';

$menu[$menu_counterparty][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/building.png" /></span> Юридические лица </a>';
$menu[$menu_counterparty][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/people.png" /></span> Физические лица </a>';

//МОДУЛИ
$level[$menu_modules] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span>Модули<b class="caret"></b></a>';

$menu[$menu_modules][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/payment.png" /></span> Модули оплаты </a>';
$menu[$menu_modules][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/shipping.png" /></span> Модули доставки </a>';

//ИНСТРУМЕНТЫ
$level[$menu_tools] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span> ' . $lang['menu_tools'] . ' <b class="caret"></b></a>';

$menu[$menu_tools][0] = '<a href="/controller/admin/pages/error_log/error_log.php"><span><img src="/view/default/admin/images/icons/16x16/error.png" /></span> ' . $lang['menu_error_log'] . ' </a>';
$menu[$menu_tools][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/folder_explore.png" /></span> Файловый менеджер </a>';
$menu[$menu_tools][2] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/backup.png" /></span> Бэкап </a>';
$menu[$menu_tools][3] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/server_info.png" /></span> Информация о сервере </a>';
$menu[$menu_tools][4] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/online.png" /></span> Кто в онлайне </a>';

//НАСТРОЙКИ
$level[$menu_prefences] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span> Настройки <b class="caret"></b></a>';

$menu[$menu_prefences][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/configure.png" /></span> Конфигурация </a>';
$menu[$menu_prefences][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/admins.png" /></span> Администраторы </a>';
$menu[$menu_prefences][2] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/templates.png" /></span> Шаблоны </a>';
$menu[$menu_prefences][3] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/currencies.png" /></span> Валюты </a>';
$menu[$menu_prefences][4] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/world.png" /></span> Страны </a>';
$menu[$menu_prefences][5] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/zones.png" /></span> Зоны</a>';
$menu[$menu_prefences][6] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/taxes.png" /></span> Налоги </a>';
$menu[$menu_prefences][7] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/locale.png" /></span> Языки </a>';

//ПОМОЩЬ
$level[$menu_help] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span> ' . $lang['menu_help'] . ' <b class="caret"></b></a>';

$menu[$menu_help][0] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src="/view/default/admin/images/icons/16x16/folder_wrench.png" /></span> ' . $lang['menu_extra'] . ' <b class="caret"></b></a>';
$submenu[$menu_help][0][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/wrench_orange.png" /></span> ' . $lang['menu_support'] . '</a>';

$menu[$menu_help][1] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src="/view/default/admin/images/icons/16x16/locale.png" /></span> ' . $lang['menu_languages'] . ' <b class="caret"></b></a>';

//Сделать парсер языков для вывода списка языков
$submenu[$menu_help][1][0] = '<a href="#"><span><img src="/view/default/admin/images/worldflags/ru.png" /></span> ' . $lang['menu_language'] . ' </a>';
$submenu[$menu_help][1][1] = '<a href="#"><span><img src="/view/default/admin/images/worldflags/gb.png" />Английский</span>  </a>';

$menu[$menu_help][2] = '<a target="_blank" href="/controller/catalog/index.php"><span><img src="/view/default/admin/images/icons/16x16/home.png" /></span> ' . $lang['menu_catalog'] . '</a>';

//ВЫХОД
$level[$menu_exit] = '<span></span><a href="/controller/admin/verify/logout.php">' . $lang['menu_exit'] . '</a>';

?>
