<?php
// ****** Copyright © 2018 eMarket *****// 
//   GNU GENERAL PUBLIC LICENSE v.3.0   //    
// https://github.com/musicman3/eMarket //
// *************************************//
// 
//LOAD CLASS VALID
require_once($_SERVER['DOCUMENT_ROOT'] . '/model/classes/valid.php');
$VALID = new eMarket\Model\Valid\ValidClass;

//LOAD CLASS PDO
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/classes/pdo.php');
$PDO = new eMarket\Model\Pdo\PdoClass;

//LOAD CLASS VIEW
require_once($VALID->inSERVER('DOCUMENT_ROOT') . '/model/classes/view.php');
$VIEW = new eMarket\Model\View\ViewClass;

?>
