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
$menu_tools = '4'; //ИНСТРУМЕНТЫ
$menu_help = '5'; //ПОМОЩЬ
$menu_exit = '6'; //ВЫХОД
//МАГАЗИН
// параметры 1 уровня: [0] - url, [1] - Название, [2] - наличие подменю
// параметры 2 уровня: [0] - url, [1] - картинка, [2] - Название, [3] - наличие target="_blank", [4] - наличие подменю
// параметры 3 уровня: [0] - url, [1] - картинка, [2] - Название
$level[$menu_market] = array('#', 'Магазин', 'true');

$menu[$menu_market][0] = array('?route=stock', 'glyphicon glyphicon-barcode', lang('title_stock_index'), '', 'false');
$menu[$menu_market][1] = array('?route=manufacturers', 'glyphicon glyphicon-object-align-bottom', lang('title_manufacturers_index'), '', 'false');
$menu[$menu_market][2] = array('#', 'glyphicon glyphicon-paperclip', 'Атрибуты', '', 'false');
$menu[$menu_market][3] = array('#', 'glyphicon glyphicon-hourglass', 'Ожидаемые', '', 'false');
$menu[$menu_market][4] = array('?route=settings', 'glyphicon glyphicon-cog', lang('title_settings_index'), '', 'false');

//ПРОДАЖИ
$level[$menu_sales] = array('#', 'Продажи', 'true');

$menu[$menu_sales][0] = array('?route=orders', 'glyphicon glyphicon-shopping-cart', lang('title_orders_index'), '', 'false');
$menu[$menu_sales][1] = array('#', 'glyphicon glyphicon-import', 'Возвраты', '', 'false');

//МАРКЕТИНГ
$level[$menu_marketing] = array('#', 'Маркетинг', 'true');

$menu[$menu_marketing][0] = array('#', 'glyphicon glyphicon-tag', 'Распродажи', '', 'false');
$menu[$menu_marketing][1] = array('#', 'glyphicon glyphicon-bullhorn', 'Рекомендуемые', '', 'false');
$menu[$menu_marketing][2] = array('#', 'glyphicon glyphicon-gift', 'Купоны', '', 'false');
$menu[$menu_marketing][3] = array('#', 'glyphicon glyphicon-picture', 'Баннеры', '', 'false');
$menu[$menu_marketing][4] = array('#', 'glyphicon glyphicon-envelope', 'Рассылки', '', 'false');
$menu[$menu_marketing][5] = array('#', 'glyphicon glyphicon-list-alt', 'Статьи', '', 'false');
$menu[$menu_marketing][6] = array('#', 'glyphicon glyphicon-comment', 'Отзывы', '', 'false');
$menu[$menu_marketing][7] = array('#', 'glyphicon glyphicon-stats', 'Отчеты', '', 'false');

//КОНТРАГЕНТЫ
$level[$menu_count_linesparty] = array('#', 'Контрагенты', 'true');

$menu[$menu_count_linesparty][0] = array('#', 'glyphicon glyphicon-briefcase', 'Юридические лица', '', 'false');
$menu[$menu_count_linesparty][1] = array('#', 'glyphicon glyphicon-user', 'Физические лица', '', 'false');

//ИНСТРУМЕНТЫ
$level[$menu_tools] = array('#', lang('menu_tools'), 'true');

$menu[$menu_tools][0] = array('?route=error_log', 'glyphicon glyphicon-exclamation-sign', lang('menu_error_log'), '', 'false');
$menu[$menu_tools][1] = array('#', 'glyphicon glyphicon-folder-close', 'Файловый менеджер', '', 'false');
$menu[$menu_tools][2] = array('#', 'glyphicon glyphicon-compressed', 'Бэкап', '', 'false');
$menu[$menu_tools][3] = array('#', 'glyphicon glyphicon-hdd', 'Информация о сервере', '', 'false');
$menu[$menu_tools][4] = array('#', 'glyphicon glyphicon-eye-open', 'Кто в онлайне', '', 'false');

//ПОМОЩЬ
$level[$menu_help] = array('#', lang('menu_help'), 'true');

$menu[$menu_help][0] = array('#', 'glyphicon glyphicon-equalizer', lang('menu_extra'), '', 'true');
$submenu[$menu_help][0][0] = array('#', 'glyphicon glyphicon-triangle-right', lang('menu_support'));

$menu[$menu_help][1] = array('#', 'glyphicon glyphicon-globe', lang('menu_languages'), '', 'true');

//Вывод языков
for ($lng = 0; $lng < count(lang('#lang_all')); $lng++) {
    $submenu[$menu_help][1][$lng] = array(\eMarket\Set::langCurrencyPath() . '&language=' . lang('#lang_all')[$lng], 'glyphicon glyphicon-triangle-right', lang('language_name', lang('#lang_all')[$lng]));
}

$menu[$menu_help][2] = array('/', 'glyphicon glyphicon-home', lang('menu_catalog'), 'target="_blank"', 'false'); // В отдельном окне

//ВЫХОД
$level[$menu_exit] = array('?route=login&logout=ok', lang('menu_exit'), 'false');
?>
