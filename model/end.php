<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Load HTML
//
if (\eMarket\Settings::path() == 'admin') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Settings::template() . '/admin/constructor.php');
}

if (\eMarket\Settings::path() == 'catalog') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Settings::template() . '/catalog/constructor.php');
}

if (\eMarket\Settings::path() == 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Settings::template() . '/install/constructor.php');
}
//Close DB connect
\eMarket\Pdo::connect('end');
?>
