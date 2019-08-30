<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */


//$MODULES->init();
$installed = $PDO->getColAssoc("SELECT name, type FROM " . TABLE_MODULES . "", []);

if ($VALID->inPOST('add')){
    $module = explode('_', $VALID->inPOST('add'));
    $PDO->inPrepare("INSERT INTO " . TABLE_MODULES . " SET name=?, type=?, page=?, position=?, sort=?, install=?, active=?, default_module=?", [$module[1], $module[0], NULL, NULL, NULL, 1, 1, 0]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

if ($VALID->inPOST('delete')){
    $module = explode('_', $VALID->inPOST('delete'));
        // Удаляем
    $PDO->inPrepare("DELETE FROM " . TABLE_MODULES . " WHERE name=? AND type=?", [$module[1], $module[0]]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}
//$DEBUG->trace($payment_installed);
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>