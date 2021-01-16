<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */
// 
//Load HTML
//
if (\eMarket\Core\Settings::path() == 'admin') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Core\Settings::template() . '/admin/constructor.php');
}

if (\eMarket\Core\Settings::path() == 'catalog') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Core\Settings::template() . '/catalog/constructor.php');
}

if (\eMarket\Core\Settings::path() == 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . \eMarket\Core\Settings::template() . '/install/constructor.php');
}
//Close DB connect
\eMarket\Core\Pdo::connect('end');
?>
