<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Автозагрузчик классов
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/vendor/' . strtolower(str_replace('\\', '/', $class_name)) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
//
//СОЗДАЕМ ОБЪЕКТ Valid
$VALID = new eMarket\Core\Valid;
//СОЗДАЕМ ОБЪЕКТ Pdo
$PDO = new eMarket\Core\Pdo;
//СОЗДАЕМ ОБЪЕКТ View
$VIEW = new eMarket\Core\View;
//СОЗДАЕМ ОБЪЕКТ Tree
$TREE = new eMarket\Core\Tree;
//СОЗДАЕМ ОБЪЕКТ Navigation
$NAVIGATION = new eMarket\Core\Navigation;
//СОЗДАЕМ ОБЪЕКТ Debug
$DEBUG = new eMarket\Other\Debug;
//СОЗДАЕМ ОБЪЕКТ Func
$FUNC = new eMarket\Other\Func;
//СОЗДАЕМ ОБЪЕКТ Messages
$MESSAGES = new eMarket\Other\Messages;
//СОЗДАЕМ ОБЪЕКТ Messages
$SETTINGS = new eMarket\Core\Settings;
?>
