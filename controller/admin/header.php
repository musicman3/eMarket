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
	
	//LEVEL 0
	$level[0] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span> Раздел 0 <b class="caret"></b></a>';
	
	$menu[0][0] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src="/view/default/admin/images/icons/" /></span> Меню 0 <b class="caret"></b></a>';
	$submenu[0][0][0] = '<a href="http://www.mail.ru"><span><img src="/view/default/admin/images/icons/" /></span> Подменю 0</a>';
	$submenu[0][0][1] = '<a href="http://www.mail.ru"><span><img src="/view/default/admin/images/icons/" /></span> Подменю 1</a>';
	
	$menu[0][1] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src="/view/default/admin/images/icons/" /></span> Меню 1 <b class="caret"></b></a>';
	$submenu[0][1][0] = '<a href="http://www.mail.ru"><span><img src="/view/default/admin/images/icons/" /></span> Подменю 0</a>';
	$submenu[0][1][1] = '</span><a href="http://www.mail.ru"><span><img src="/view/default/admin/images/icons/" /></span> Подменю 1</a>';
	$submenu[0][1][2] = '<a href="http://www.mail.ru"><span><img src="/view/default/admin/images/icons/" /></span> Подменю 2</a>';
	$submenu[0][1][3] = '<a href="http://www.mail.ru"><span><img src="/view/default/admin/images/icons/" /></span> Подменю 3</a>';
	
	$menu[0][2] = '<a href="http://www.mail.ru"><span><img src="/view/default/admin/images/icons/" /></span> Меню 2</a>';
	
	//LEVEL 1
	$level[1] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span> '.$lang['menu_tools'].' <b class="caret"></b></a>';
	
	$menu[1][0] = '<a href="/controller/admin/pages/error_log/error_log_index.php"><span><img src="/view/default/admin/images/icons/16x16/error.png" /></span> '.$lang['menu_error_log'].'</a>';

	//LEVEL 2
	$level[2] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span></span> '.$lang['menu_help'].' <b class="caret"></b></a>';
	
	$menu[2][0] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src="/view/default/admin/images/icons/16x16/emarket.png" /></span> '.$lang['menu_extra'].' <b class="caret"></b></a>';
	$submenu[2][0][0] = '<a href="http://#"><span><img src="/view/default/admin/images/icons/16x16/wrench_orange.png" /></span> '.$lang['menu_support'].'</a>';
	
	$menu[2][1] = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span><img src="/view/default/admin/images/icons/16x16/locale.png" /></span> '.$lang['menu_languages'].' <b class="caret"></b></a>';
	//НУЖНО СДЕЛАТЬ ПАРСИНГ СПИСКА ЯЗЫКОВ И ВЫВОД В МЕНЮ
	$submenu[2][1][0] = '<a href="http://#"><span><img src="/view/default/admin/images/worldflags/ru.png" /></span> '.$lang['menu_language'].'</a>';
	$submenu[2][1][1] = '<a href="http://#"><span><img src="/view/default/admin/images/worldflags/gb.png" /></span> English</a>';
	
	$menu[2][2] = '<a target="_blank" href="/controller/catalog/index.php"><span><img src="/view/default/admin/images/icons/16x16/home.png" /></span> '.$lang['menu_catalog'].'</a>';

	//LEVEL 3
	$level[3] = '<span></span><a href="/controller/admin/verify/logout.php">'.$lang['menu_exit'].'</a>';

?>
