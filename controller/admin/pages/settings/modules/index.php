<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$installed = \eMarket\Core\Pdo::getColAssoc("SELECT name, type FROM " . TABLE_MODULES . "", []);
$installed_active = \eMarket\Core\Pdo::getColAssoc("SELECT name, type FROM " . TABLE_MODULES . " WHERE active=?", [1]);

if ($VALID->inPOST('add')) {
    $module = explode('_', $VALID->inPOST('add'));
    \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_MODULES . " SET name=?, type=?, page=?, position=?, sort=?, install=?, active=?, default_module=?", [$module[1], $module[0], NULL, NULL, NULL, 1, 1, 0]);
    
    //Загружаем БД из файла
    \eMarket\Core\Pdo::dbInstall(ROOT . '/modules/' . $module[0] . '/' . $module[1] . '/install/');

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

if ($VALID->inPOST('delete')) {
    $module = explode('_', $VALID->inPOST('delete'));
    // Удаляем
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_MODULES . " WHERE name=? AND type=?", [$module[1], $module[0]]);
    \eMarket\Core\Pdo::inPrepare("DROP TABLE " . DB_PREFIX . 'modules_' . $module[0] . '_' . $module[1], []);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

if ($VALID->inPOST('edit')) {

    if ($VALID->inPOST('switch') == 'on') {
        $active = 1;
    }
    if (!$VALID->inPOST('switch')) {
        $active = 0;
    }
    $module = explode('_', $VALID->inPOST('edit'));
    \eMarket\Core\Pdo::inPrepare("UPDATE " . TABLE_MODULES . " SET active=? WHERE name=? AND type=?", [$active, $module[1], $module[0]]);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

//$DEBUG->trace($payment_installed);
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>