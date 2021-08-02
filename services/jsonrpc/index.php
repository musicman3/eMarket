<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |    
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

error_reporting(-1);

//AUTOLOAD FOR CLASSES
require_once(getenv('DOCUMENT_ROOT') . '/vendor/autoload.php');

use eMarket\Core\{
    Tree
};

//AUTOLOAD FOR FUNCTION
foreach (Tree::filesTree(getenv('DOCUMENT_ROOT') . '/model/library/php/functions/') as $path) {
    require_once($path);
}

$eMarket = new eMarket\Core\JsonRpc();