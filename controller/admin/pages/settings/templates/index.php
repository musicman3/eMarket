<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

$layout_pages = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? ORDER BY sort ASC", ['catalog']);

$layout_header = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'header']);
$layout_content = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'content']);
$layout_boxes_left = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'boxes-left']);
$layout_boxes_right = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'boxes-right']);
$layout_footer = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'footer']);

$layout_header_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'header-basket']);
$layout_content_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'content-basket']);
$layout_boxes_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'boxes-basket']);
$layout_footer_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? ORDER BY sort ASC", ['catalog', 'footer-basket']);

//$DEBUG->trace($layout_pages);

//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */
?>