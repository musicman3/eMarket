<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
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
$VALID = new eMarket\Classes\Core\Valid;
//СОЗДАЕМ ОБЪЕКТ Pdo
$PDO = new eMarket\Classes\Core\Pdo;
//СОЗДАЕМ ОБЪЕКТ View
$VIEW = new eMarket\Classes\Core\View;
//СОЗДАЕМ ОБЪЕКТ Tree
$TREE = new eMarket\Classes\Core\Tree;
//СОЗДАЕМ ОБЪЕКТ Navigation
$NAVIGATION = new eMarket\Classes\Core\Navigation;
//СОЗДАЕМ ОБЪЕКТ Debug
$DEBUG = new eMarket\Classes\Other\Debug;
//СОЗДАЕМ ОБЪЕКТ Func
$FUNC = new eMarket\Classes\Other\Func;

?>
