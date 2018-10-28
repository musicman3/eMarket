<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
//Автозагрузчик классов
spl_autoload_register(function ($class_name) {
    $class_path = strtolower(str_replace('\\', '/', $class_name));
    require_once 'vendor/' . $class_path . '.php';
});
//
//ЗАГРУЖАЕМ CLASS Valid
$VALID = new eMarket\Classes\Core\Valid;
//
//ЗАГРУЖАЕМ CLASS Pdo
$PDO = new eMarket\Classes\Core\Pdo;
//
//ЗАГРУЖАЕМ БАЗОВЫЕ ПЕРЕМЕННЫЕ
$TEMPLATE = 'default'; //название текущего шаблона
$PATH = explode('/', ($VALID->inSERVER('REQUEST_URI')))[2]; //Текущая ветка (admin или catalog)
$THIS_DIR = basename(getcwd()); //Текущая директория
//
//ЗАГРУЖАЕМ CLASS View
$VIEW = new eMarket\Classes\Core\View;

?>
