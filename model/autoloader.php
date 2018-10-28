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

//LOAD CLASS Valid
$VALID = new eMarket\Classes\Core\Valid;

//LOAD CLASS Pdo
$PDO = new eMarket\Classes\Core\Pdo;

//LOAD CLASS View
$TEMPLATE = 'default'; //название текущего шаблона
$VIEW = new eMarket\Classes\Core\View;

?>
