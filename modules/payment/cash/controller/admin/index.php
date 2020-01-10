<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$MODULE_DB = \eMarket\Set::moduleDatabase();

// Если нажали на кнопку Сохранить
if (\eMarket\Valid::inPOST('save')) {

    $data = \eMarket\Pdo::getCellFalse("SELECT * FROM " . $MODULE_DB, []);
    if ($data == FALSE) {
        if (empty(\eMarket\Valid::inPOST('multiselect')) == FALSE) {
            $multiselect = \eMarket\Valid::inPOST('multiselect');
            $multiselect_implode = implode(',', $multiselect);
            \eMarket\Pdo::inPrepare("INSERT INTO " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Valid::inPOST('order_status'), $multiselect_implode]);
        }
    } elseif (empty(\eMarket\Valid::inPOST('multiselect')) == FALSE) {
        $multiselect = \eMarket\Valid::inPOST('multiselect');
        $multiselect_implode = implode(',', $multiselect);
        \eMarket\Pdo::inPrepare("UPDATE " . $MODULE_DB . " SET order_status=?, shipping_module=?", [\eMarket\Valid::inPOST('order_status'), $multiselect_implode]);
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