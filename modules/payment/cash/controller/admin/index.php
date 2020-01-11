<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$MODULE_DB = \eMarket\Set::moduleDatabase();

$shipping_method = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_MODULES . " WHERE type=? AND install=? AND active=? ORDER BY name ASC", ['shipping', 1, 1]);
$order_status = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_ORDER_STATUS . " WHERE language=? ORDER BY sort DESC", [lang('#lang_all')[0]]);
$shipping_val = json_decode(\eMarket\Pdo::getCellFalse("SELECT shipping_module FROM " . $MODULE_DB, []), 1);

// Если нажали на кнопку Сохранить
if (\eMarket\Valid::inPOST('save')) {

    $data = \eMarket\Pdo::getCellFalse("SELECT * FROM " . $MODULE_DB, []);
    if ($data == FALSE) {
        if (empty(\eMarket\Valid::inPOST('multiselect')) == FALSE) {
            $multiselect = json_encode(\eMarket\Valid::inPOST('multiselect'));
            \eMarket\Pdo::inPrepare("INSERT INTO " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Valid::inPOST('order_status'), $multiselect]);
        }
    } elseif (empty(\eMarket\Valid::inPOST('multiselect')) == FALSE) {
        $multiselect = json_encode(\eMarket\Valid::inPOST('multiselect'));
        \eMarket\Pdo::inPrepare("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Valid::inPOST('order_status'), $multiselect]);
    } else {
        \eMarket\Pdo::inPrepare("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Valid::inPOST('order_status'), NULL]);
    }

    // Выводим сообщение об успехе
    $_SESSION['message'] = ['success', lang('action_completed_successfully')];
    exit;
}

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_MOD_END = __DIR__;
// Загружаем разметку модуля
require_once (\eMarket\View::routingModules('view') . '/index.php');
?>