<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$MODULE_DB = \eMarket\Settings::moduleDatabase();

$shipping_method = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=? ORDER BY name ASC", ['shipping', 1]);
$order_status = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
$order_status_selected = \eMarket\Pdo::getCellFalse("SELECT order_status FROM " . $MODULE_DB, []);
$shipping_val = json_decode(\eMarket\Pdo::getCellFalse("SELECT shipping_module FROM " . $MODULE_DB, []), 1);

// Если нажали на кнопку Сохранить
if (\eMarket\Valid::inPOST('save')) {

    $data = \eMarket\Pdo::getCellFalse("SELECT * FROM " . $MODULE_DB, []);
    if ($data == FALSE) {
        if (empty(\eMarket\Valid::inPOST('multiselect')) == FALSE) {
            $multiselect = json_encode(\eMarket\Valid::inPOST('multiselect'));
            \eMarket\Pdo::action("INSERT INTO " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Valid::inPOST('order_status'), $multiselect]);
        }
    } elseif (empty(\eMarket\Valid::inPOST('multiselect')) == FALSE) {
        $multiselect = json_encode(\eMarket\Valid::inPOST('multiselect'));
        \eMarket\Pdo::action("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Valid::inPOST('order_status'), $multiselect]);
    } else {
        \eMarket\Pdo::action("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Valid::inPOST('order_status'), NULL]);
    }

    // Выводим сообщение об успехе
    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
    exit;
}

\eMarket\Settings::jsModulesHandler();
// Загружаем разметку модуля
require_once (\eMarket\View::routingModules('view') . '/index.php');
?>