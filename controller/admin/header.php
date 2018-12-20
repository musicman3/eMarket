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
$level[$menu_market] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Магазин<b class="caret"></b></a>';

$menu[$menu_market][0] = '<a href="/controller/admin/pages/stock/index.php"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/products.png" /> ' . lang('title_stock_index') . ' </a>';
$menu[$menu_market][1] = '<a href="/controller/admin/pages/stock/products/products.php"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/products.png" /> ' . lang('title_products_products') . ' </a>';
$menu[$menu_market][2] = '<a href="/controller/admin/pages/manufacturers/index.php"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/manufacturers.png" /> ' . lang('title_manufacturers_index') . ' </a>';
$menu[$menu_market][3] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/attributes.png" /> Атрибуты </a>';
$menu[$menu_market][4] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/date.png" /> Ожидаемые </a>';
$menu[$menu_market][5] = '<a href="/controller/admin/pages/settings/"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/configure.png" /> ' . lang('title_settings_index') . ' </a>';

//ПРОДАЖИ
$level[$menu_sales] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Продажи<b class="caret"></b></a>';

$menu[$menu_sales][0] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/orders.png" /> Заказы </a>';
$menu[$menu_sales][1] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/return.png" /> Возвраты </a>';

//МАРКЕТИНГ
$level[$menu_marketing] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Маркетинг<b class="caret"></b></a>';

$menu[$menu_marketing][0] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/specials.png" /> Распродажи </a>';
$menu[$menu_marketing][1] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/feature.png" /> Рекомендуемые </a>';
$menu[$menu_marketing][2] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/coupons.png" /> Купоны </a>';
$menu[$menu_marketing][3] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/banners.png" /> Баннеры </a>';
$menu[$menu_marketing][4] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/email_send.png" /> Рассылки </a>';
$menu[$menu_marketing][5] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/article.png" /> Статьи </a>';
$menu[$menu_marketing][6] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/reviews.png" /> Отзывы </a>';
$menu[$menu_marketing][7] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/chart.png" /> Отчеты </a>';

//КОНТРАГЕНТЫ
$level[$menu_count_linesparty] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Контрагенты<b class="caret"></b></a>';

$menu[$menu_count_linesparty][0] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/building.png" /> Юридические лица </a>';
$menu[$menu_count_linesparty][1] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/people.png" /> Физические лица </a>';

//МОДУЛИ
$level[$menu_modules] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Модули<b class="caret"></b></a>';

$menu[$menu_modules][0] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/payment.png" /> Модули оплаты </a>';
$menu[$menu_modules][1] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/shipping.png" /> Модули доставки </a>';

//ИНСТРУМЕНТЫ
$level[$menu_tools] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . lang('menu_tools') . '<b class="caret"></b></a>';

$menu[$menu_tools][0] = '<a href="/controller/admin/pages/error_log/"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/error.png" /> ' . lang('menu_error_log') . ' </a>';
$menu[$menu_tools][1] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/folder_explore.png" /> Файловый менеджер </a>';
$menu[$menu_tools][2] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/backup.png" /> Бэкап </a>';
$menu[$menu_tools][3] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/server_info.png" /> Информация о сервере </a>';
$menu[$menu_tools][4] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/online.png" /> Кто в онлайне </a>';

//ПОМОЩЬ
$level[$menu_help] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown">' . lang('menu_help') . '<b class="caret"></b></a>';

$menu[$menu_help][0] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/folder_wrench.png" /> ' . lang('menu_extra') . ' <b class="caret"></b></a>';
$submenu[$menu_help][0][0] = '<a href="#"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/wrench_orange.png" /> ' . lang('menu_support') . '</a>';

$menu[$menu_help][1] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/locale.png" /> ' . lang('menu_languages') . ' <b class="caret"></b></a>';

//Вывод языков
for ($lng = 0; $lng < count(lang('#lang_all')); $lng++) {
    $submenu[$menu_help][1][$lng] = '<a href="/controller/admin/?language=' . lang('#lang_all')[$lng] . '"><img src="/view/' . $SET->template() . '/admin/images/langflags/' . lang('#lang_all')[$lng] . '.png" /> ' . lang('language_name', lang('#lang_all')[$lng]) . ' </a>';
}

$menu[$menu_help][2] = '<a target="_blank" href="/controller/catalog/index.php"><img src="/view/' . $SET->template() . '/admin/images/icons/16x16/home.png" /> ' . lang('menu_catalog') . '</a>';

//ВЫХОД
$level[$menu_exit] = '<a href="/controller/admin/login/?logout=ok">' . lang('menu_exit') . '</a>';
?>
