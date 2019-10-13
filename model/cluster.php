<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//АВТОЗАГРУЗЧИК КЛАССОВ
require_once('vendor/autoload.php');
//

//СОЗДАЕМ ОБЪЕКТЫ OTHER
$FILES = new eMarket\Other\Files;

//АВТОЗАГРУЗЧИК ФУНКЦИЙ
//Получаем список путей к файлам функций
foreach (\eMarket\Core\Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/functions/') as $path) {
    require_once($path);
}
?>
