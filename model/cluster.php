<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//АВТОЗАГРУЗЧИК КЛАССОВ
require_once('vendor/autoload.php');
//
//СОЗДАЕМ ОБЪЕКТЫ CORE
$NAVIGATION = new eMarket\Core\Navigation;
$TREE = new eMarket\Core\Tree;

//СОЗДАЕМ ОБЪЕКТЫ OTHER
$AJAX = new eMarket\Other\Ajax;
$DEBUG = new eMarket\Other\Debug;
$FILES = new eMarket\Other\Files;
$FUNC = new eMarket\Other\Func;

//АВТОЗАГРУЗЧИК ФУНКЦИЙ
//Получаем список путей к файлам функций
foreach ($TREE->filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}
?>
