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
//ЗАГРУЖАЕМ CLASS Valid
$VALID = new eMarket\Classes\Core\Valid;
//ЗАГРУЖАЕМ CLASS Pdo
$PDO = new eMarket\Classes\Core\Pdo;
//ЗАГРУЖАЕМ CLASS View
$VIEW = new eMarket\Classes\Core\View;
//ЗАГРУЖАЕМ CLASS Tree
$TREE = new eMarket\Classes\Core\Tree;
//ЗАГРУЖАЕМ CLASS Navigation
$NAVIGATION = new eMarket\Classes\Core\Navigation;
//ЗАГРУЖАЕМ CLASS Debug
$DEBUG = new eMarket\Classes\Other\Debug;
//ЗАГРУЖАЕМ CLASS Func
$FUNC = new eMarket\Classes\Other\Func;

?>
