<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-= 
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

//СОРТИРОВКА
$menu_market = '0'; //МАГАЗИН
$menu_sales = '1'; // ПРОДАЖИ
$menu_marketing = '2'; //МАРКЕТИНГ
$menu_count_linesparty = '3'; //КОНТРАГЕНТЫ
$menu_modules = '4'; //МОДУЛИ
$menu_tools = '5'; //ИНСТРУМЕНТЫ
$menu_help = '6'; //ПОМОЩЬ
$menu_exit = '7'; //ВЫХОД
//МАГАЗИН
$level[$menu_market] = array('#', 'Магазин');

$menu[$menu_market][0] = array('/controller/admin/pages/stock/index.php', 'products.png', lang('title_stock_index'), '');
$menu[$menu_market][1] = array('/controller/admin/pages/stock/products/products.php', 'products.png', lang('title_products_products'), '');
$menu[$menu_market][2] = array('/controller/admin/pages/manufacturers/index.php', 'manufacturers.png', lang('title_manufacturers_index'), '');
$menu[$menu_market][3] = array('#', 'attributes.png', 'Атрибуты', '');
$menu[$menu_market][4] = array('#', 'date.png', 'Ожидаемые', '');
$menu[$menu_market][5] = array('/controller/admin/pages/settings/', 'configure.png', lang('title_settings_index'), '');

//ПРОДАЖИ
$level[$menu_sales] = array('#', 'Продажи');

$menu[$menu_sales][0] = array('#', 'orders.png', 'Заказы', '');
$menu[$menu_sales][1] = array('#', 'return.png', 'Возвраты', '');

//МАРКЕТИНГ
$level[$menu_marketing] = array('#', 'Маркетинг');

$menu[$menu_marketing][0] = array('#', 'specials.png', 'Распродажи', '');
$menu[$menu_marketing][1] = array('#', 'feature.png', 'Рекомендуемые', '');
$menu[$menu_marketing][2] = array('#', 'coupons.png', 'Купоны', '');
$menu[$menu_marketing][3] = array('#', 'banners.png', 'Баннеры', '');
$menu[$menu_marketing][4] = array('#', 'email_send.png', 'Рассылки', '');
$menu[$menu_marketing][5] = array('#', 'article.png', 'Статьи', '');
$menu[$menu_marketing][6] = array('#', 'reviews.png', 'Отзывы', '');
$menu[$menu_marketing][7] = array('#', 'chart.png', 'Отчеты', '');

//КОНТРАГЕНТЫ
$level[$menu_count_linesparty] = array('#', 'Контрагенты');

$menu[$menu_count_linesparty][0] = array('#', 'building.png', 'Юридические лица', '');
$menu[$menu_count_linesparty][1] = array('#', 'people.png', 'Физические лица', '');

//МОДУЛИ
$level[$menu_modules] = array('#', 'Модули');

$menu[$menu_modules][0] = array('#', 'payment.png', 'Модули оплаты', '');
$menu[$menu_modules][1] = array('#', 'shipping.png', 'Модули доставки', '');

//ИНСТРУМЕНТЫ
$level[$menu_tools] = array('#', lang('menu_tools'));

$menu[$menu_tools][0] = array('/controller/admin/pages/error_log/', 'error.png', lang('menu_error_log'), '');
$menu[$menu_tools][1] = array('#', 'folder_explore.png', 'Файловый менеджер', '');
$menu[$menu_tools][2] = array('#', 'backup.png', 'Бэкап', '');
$menu[$menu_tools][3] = array('#', 'server_info.png', 'Информация о сервер', '');
$menu[$menu_tools][4] = array('#', 'online.png', 'Кто в онлайне', '');

//ПОМОЩЬ
$level[$menu_help] = array('#', lang('menu_help'));

$menu[$menu_help][0] = array('#', 'folder_wrench.png', lang('menu_extra'), '');
$submenu[$menu_help][0][0] = array('#', '/admin/images/icons/16x16/wrench_orange.png', lang('menu_support'));

$menu[$menu_help][1] = array('#', 'locale.png', lang('menu_languages'), '');

//Вывод языков
for ($lng = 0; $lng < count(lang('#lang_all')); $lng++) {
    $submenu[$menu_help][1][$lng] = array('/controller/admin/?language=' . lang('#lang_all')[$lng], '/admin/images/langflags/' . lang('#lang_all')[$lng] . '.png', lang('language_name', lang('#lang_all')[$lng]));
}

$menu[$menu_help][2] = array('/controller/catalog/index.php', 'home.png', lang('menu_catalog'), 'target="_blank"'); // В отдельном окне

//ВЫХОД
$level[$menu_exit] = array('/controller/admin/login/?logout=ok', lang('menu_exit'));
?>
