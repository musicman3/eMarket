<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
//Автозагрузчик классов
spl_autoload_register(function ($class_name) {
    strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class_name));
    require_once 'vendor/' . $class_name . '.php';
});

//LOAD CLASS Valid
$VALID = new emarket\classes\core\valid;

//LOAD CLASS Pdo
$PDO = new emarket\classes\core\pdo;

//LOAD CLASS View
$TEMPLATE = 'default'; //название текущего шаблона
$VIEW = new emarket\classes\core\view;

?>
