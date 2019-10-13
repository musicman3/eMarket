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
$TREE = new eMarket\Core\Tree;

//СОЗДАЕМ ОБЪЕКТЫ OTHER
$FILES = new eMarket\Other\Files;

//АВТОЗАГРУЗЧИК ФУНКЦИЙ
//Получаем список путей к файлам функций
foreach ($TREE->filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}
?>
