<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Загружаем HTML
//
//ВЫВОД ТОЛЬКО В АДМИНКЕ
if (\eMarket\Core\Set::path() == 'admin') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Core\Set::template() . '/admin/constructor.php');
}
//ВЫВОД ТОЛЬКО В КАТАЛОГЕ
if (\eMarket\Core\Set::path() == 'catalog') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Core\Set::template() . '/catalog/constructor.php');
}
//ВЫВОД ТОЛЬКО В КАТАЛОГЕ
if (\eMarket\Core\Set::path() == 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Core\Set::template() . '/install/constructor.php');
}
//Закрываем соединение с БД
\eMarket\Core\Pdo::connect('end');
?>
