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
$AUTORIZE = new eMarket\Core\Autorize;
$NAVIGATION = new eMarket\Core\Navigation;
$MODULES = new eMarket\Core\Modules;
$PDO = new eMarket\Core\Pdo;
$SET = new eMarket\Core\Set;
$TREE = new eMarket\Core\Tree;
$VALID = new eMarket\Core\Valid;
$VIEW = new eMarket\Core\View;

//СОЗДАЕМ ОБЪЕКТЫ OTHER
$AJAX = new eMarket\Other\Ajax;
$CART = new eMarket\Other\Cart;
$DEBUG = new eMarket\Other\Debug;
$FILES = new eMarket\Other\Files;
$FUNC = new eMarket\Other\Func;
$MESSAGES = new eMarket\Other\Messages;
$PRODUCTS = new eMarket\Other\Products;
//
//АВТОЗАГРУЗЧИК ФУНКЦИЙ
//Получаем список путей к файлам функций
foreach ($TREE->filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}

?>
