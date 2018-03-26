<?php
/****** Copyright © 2018 eMarket ******* 
*   GNU GENERAL PUBLIC LICENSE v.3.0   *    
* https://github.com/musicman3/eMarket *
***************************************/

    //LOAD CLASS PDO
    require_once($_SERVER['DOCUMENT_ROOT'] . '/model/classes/pdo.php');
    $PDO = new Model\Classes\Pdo\PdoClass;

    //LOAD CLASS VALID
    require_once($_SERVER['DOCUMENT_ROOT'] . '/model/classes/valid.php');
    $VALID = new Model\Classes\Valid\ValidClass;

    //LOAD CLASS VIEW
    require_once($_SERVER['DOCUMENT_ROOT'] . '/model/classes/view.php');
    $View = new Model\Classes\View\ViewClass;
?>
