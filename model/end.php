<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

use eMarket\Core\{
    Pdo,
    Settings,
    Valid,
    Autorize
};

if (Settings::path() == 'admin') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/admin/constructor.php');
    $_SESSION['csrf_token'] = Autorize::csrfToken();
}

if (Settings::path() == 'catalog' && Valid::inGET('route') !== 'callback') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/catalog/constructor.php');
    $_SESSION['csrf_token'] = Autorize::csrfToken();
}

if (Settings::path() == 'install') {
    require_once(getenv('DOCUMENT_ROOT') . '/view/' . Settings::template() . '/install/constructor.php');
}
//Close DB connect
Pdo::connect('end');

