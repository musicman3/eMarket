<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$installed = \eMarket\Pdo::getColAssoc("SELECT name, type FROM " . TABLE_MODULES . "", []);
$installed_active = \eMarket\Pdo::getColAssoc("SELECT name, type FROM " . TABLE_MODULES . " WHERE active=?", [1]);

if (\eMarket\Valid::inPOST('add')) {
    $module = explode('_', \eMarket\Valid::inPOST('add'));
    $namespace = '\eMarket\Modules\\' . ucfirst($module[0]) . '\\' . ucfirst($module[1]);
    $namespace::install($module);

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('delete')) {
    $module = explode('_', \eMarket\Valid::inPOST('delete'));
    $namespace = '\eMarket\Modules\\' . ucfirst($module[0]) . '\\' . ucfirst($module[1]);
    $namespace::uninstall($module);

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inPOST('edit_active')) {

    if (\eMarket\Valid::inPOST('switch_active') == 'on') {
        $active = 1;
    }
    if (!\eMarket\Valid::inPOST('switch_active')) {
        $active = 0;
    }
    $module = explode('_', \eMarket\Valid::inPOST('edit_active'));
    \eMarket\Pdo::action("UPDATE " . TABLE_MODULES . " SET active=? WHERE name=? AND type=?", [$active, $module[1], $module[0]]);
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
\eMarket\Settings::$JS_END = __DIR__;
?>