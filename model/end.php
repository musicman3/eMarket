<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Загружаем HTML
require_once(getenv('DOCUMENT_ROOT') . '/model/html.php');

//Закрываем соединение с БД
$PDO->connect('end'); 
?>
