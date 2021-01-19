<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

// 
//Load HTML
//
use \eMarket\Core\{
    Pdo,
    Settings
};

if (Settings::path() == 'admin') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/admin/constructor.php');
}

if (Settings::path() == 'catalog') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/catalog/constructor.php');
}

if (Settings::path() == 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/install/constructor.php');
}
//Close DB connect
Pdo::connect('end');
?>
