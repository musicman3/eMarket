<?php
/****** Copyright В© 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

	error_reporting(-1);

	// Структура меню
	$level = array();
	$menu = array();
	$submenu = array();

	//СОРТИРОВКА
	$menu_market = '0'; //МАГАЗИН
	$menu_sales = '1'; // ПРОДАЖИ
	$menu_counterparty = '2'; //КОНТРАГЕНТЫ
	$menu_tools = '3'; //ИНСТРУМЕНТЫ
	$menu_help = '4'; //ПОМОЩЬ
	$menu_exit = '5'; //ВЫХОД
	
	
	//МАГАЗИН
	$level[$menu_market] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span>Магазин<b class="caret"></b></a>';
	
	$menu[$menu_market][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/folder.png" /></span> Категории </a>';
	$menu[$menu_market][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/products.png" /></span> Товары </a>';
	$menu[$menu_market][2] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/manufacturers.png" /></span> Производители </a>';
	$menu[$menu_market][3] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/attach.png" /></span> Варианты </a>';
	$menu[$menu_market][4] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/specials.png" /></span> Распродажи </a>';
	$menu[$menu_market][5] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/feature.png" /></span> Рекомендуемые </a>';
	$menu[$menu_market][6] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/date.png" /></span> Ожидаемые </a>';
	$menu[$menu_market][7] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/reviews.png" /></span> Отзывы </a>';
	$menu[$menu_market][8] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/article.png" /></span> Статьи </a>';

	//ПРОДАЖИ
	$level[$menu_sales] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span>Продажи<b class="caret"></b></a>';
	
	$menu[$menu_sales][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/orders.png" /></span> Заказы </a>';

	//КОНТРАГЕНТЫ
	$level[$menu_counterparty] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span>Контрагенты<b class="caret"></b></a>';
	
	$menu[$menu_counterparty][0] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/building.png" /></span> Юридические лица </a>';
	$menu[$menu_counterparty][1] = '<a href="#"><span><img src="/view/default/admin/images/icons/16x16/people.png" /></span> Физические лица </a>';
	
	//ИНСТРУМЕНТЫ
	$level[$menu_tools] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span> '.$lang['menu_tools'].' <b class="caret"></b></a>';
	
	$menu[$menu_tools][0] = '<a href="/controller/admin/pages/error_log/error_log_index.php"><span><img src="/view/default/admin/images/icons/16x16/error.png" /></span> '.$lang['menu_error_log'].'</a>';

	//ПОМОЩЬ
	$level[$menu_help] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span> '.$lang['menu_help'].' <b class="caret"></b></a>';
	
	$menu[$menu_help][0] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src="/view/default/admin/images/icons/16x16/folder_wrench.png" /></span> '.$lang['menu_extra'].' <b class="caret"></b></a>';
	$submenu[$menu_help][0][0] = '<a href="http://#"><span><img src="/view/default/admin/images/icons/16x16/wrench_orange.png" /></span> '.$lang['menu_support'].'</a>';
	
	$menu[$menu_help][1] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src="/view/default/admin/images/icons/16x16/locale.png" /></span> '.$lang['menu_languages'].' <b class="caret"></b></a>';

	$submenu[$menu_help][1][0] = '<a href="http://#"><span><img src="/view/default/admin/images/worldflags/ru.png" /></span> '.$lang['menu_language'].'</a>';
	$submenu[$menu_help][1][1] = '<a href="http://#"><span><img src="/view/default/admin/images/worldflags/gb.png" /></span> English</a>';
	
	$menu[$menu_help][2] = '<a target="_blank" href="/controller/catalog/index.php"><span><img src="/view/default/admin/images/icons/16x16/home.png" /></span> '.$lang['menu_catalog'].'</a>';

	//ВЫХОД
	$level[$menu_exit] = '<span></span><a href="/controller/admin/verify/logout.php">'.$lang['menu_exit'].'</a>';

?>
