<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Загружаем HTML
//
//ВЫВОД ТОЛЬКО В АДМИНКЕ
if ($SET->path() == 'admin') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . $SET->template() . '/admin/constructor.php');
}
//ВЫВОД ТОЛЬКО В КАТАЛОГЕ
if ($SET->path() == 'catalog') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . $SET->template() . '/catalog/constructor.php');
}
//ВЫВОД ТОЛЬКО В КАТАЛОГЕ
if ($SET->path() == 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . $SET->template() . '/install/constructor.php');
}
//Закрываем соединение с БД
$PDO->connect('end');
?>
