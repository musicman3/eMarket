<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$MODULE_DB = \eMarket\Core\Settings::moduleDatabase();

$shipping_method = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND active=? ORDER BY name ASC", ['shipping', 1]);
$order_status = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
$order_status_selected = \eMarket\Core\Pdo::getCellFalse("SELECT order_status FROM " . $MODULE_DB, []);
$shipping_val = json_decode(\eMarket\Core\Pdo::getCellFalse("SELECT shipping_module FROM " . $MODULE_DB, []), 1);

// Если нажали на кнопку Сохранить
if (\eMarket\Core\Valid::inPOST('save')) {

    $data = \eMarket\Core\Pdo::getCellFalse("SELECT * FROM " . $MODULE_DB, []);
    if ($data == FALSE) {
        if (empty(\eMarket\Core\Valid::inPOST('multiselect')) == FALSE) {
            $multiselect = json_encode(\eMarket\Core\Valid::inPOST('multiselect'));
            \eMarket\Core\Pdo::action("INSERT INTO " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Core\Valid::inPOST('order_status'), $multiselect]);
        }
    } elseif (empty(\eMarket\Core\Valid::inPOST('multiselect')) == FALSE) {
        $multiselect = json_encode(\eMarket\Core\Valid::inPOST('multiselect'));
        \eMarket\Core\Pdo::action("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Core\Valid::inPOST('order_status'), $multiselect]);
    } else {
        \eMarket\Core\Pdo::action("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Core\Valid::inPOST('order_status'), NULL]);
    }

    // Выводим сообщение об успехе
    \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
    exit;
}

\eMarket\Core\Settings::jsModulesHandler();
// Загружаем разметку модуля
require_once (\eMarket\Core\View::routingModules('view') . '/index.php');
?>