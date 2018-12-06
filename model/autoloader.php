<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//АВТОЗАГРУЗЧИК КЛАССОВ
spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/classes/vendor/' . strtolower(str_replace('\\', '/', $class_name)) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
//
//СОЗДАЕМ ОБЪЕКТЫ CORE
$AUTORIZE = new eMarket\Core\Autorize;
$LANG = new eMarket\Core\Lang;
$NAVIGATION = new eMarket\Core\Navigation;
$PDO = new eMarket\Core\Pdo;
$SET = new eMarket\Core\Set;
$TREE = new eMarket\Core\Tree;
$VALID = new eMarket\Core\Valid;
$VIEW = new eMarket\Core\View;

//СОЗДАЕМ ОБЪЕКТЫ OTHER
$EAC = new eMarket\Other\Eac;
$DEBUG = new eMarket\Other\Debug;
$FUNC = new eMarket\Other\Func;
$MESSAGES = new eMarket\Other\Messages;

//АВТОЗАГРУЗЧИК ФУНКЦИЙ
//Получаем список путей к файлам функций
foreach ($TREE->filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $i) {
    require_once($i);
}
?>
