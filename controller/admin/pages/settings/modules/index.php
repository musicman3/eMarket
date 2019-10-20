<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$installed = \eMarket\Pdo::getColAssoc("SELECT name, type FROM " . TABLE_MODULES . "", []);
$installed_active = \eMarket\Pdo::getColAssoc("SELECT name, type FROM " . TABLE_MODULES . " WHERE active=?", [1]);

if (\eMarket\Valid::inPOST('add')) {
    $module = explode('_', \eMarket\Valid::inPOST('add'));
    \eMarket\Pdo::inPrepare("INSERT INTO " . TABLE_MODULES . " SET name=?, type=?, page=?, position=?, sort=?, install=?, active=?", [$module[1], $module[0], NULL, NULL, NULL, 1, 1]);
    
    //Загружаем БД из файла
    \eMarket\Pdo::dbInstall(ROOT . '/modules/' . $module[0] . '/' . $module[1] . '/install/');

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

if (\eMarket\Valid::inPOST('delete')) {
    $module = explode('_', \eMarket\Valid::inPOST('delete'));
    // Удаляем
    \eMarket\Pdo::inPrepare("DELETE FROM " . TABLE_MODULES . " WHERE name=? AND type=?", [$module[1], $module[0]]);
    \eMarket\Pdo::inPrepare("DROP TABLE " . DB_PREFIX . 'modules_' . $module[0] . '_' . $module[1], []);
    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
}

if (\eMarket\Valid::inPOST('edit')) {

    if (\eMarket\Valid::inPOST('switch') == 'on') {
        $active = 1;
    }
    if (!\eMarket\Valid::inPOST('switch')) {
        $active = 0;
    }
    $module = explode('_', \eMarket\Valid::inPOST('edit'));
    \eMarket\Pdo::inPrepare("UPDATE " . TABLE_MODULES . " SET active=? WHERE name=? AND type=?", [$active, $module[1], $module[0]]);
}

//\eMarket\Debug::trace($payment_installed);
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;
?>