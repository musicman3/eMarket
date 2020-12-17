<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Загружаем HTML / Load HTML
//
if (\eMarket\Set::path() == 'admin') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Set::template() . '/admin/constructor.php');
}

if (\eMarket\Set::path() == 'catalog') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Set::template() . '/catalog/constructor.php');
}

if (\eMarket\Set::path() == 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Set::template() . '/install/constructor.php');
}
//Закрываем соединение с БД / Close DB connect
\eMarket\Pdo::connect('end');
?>
