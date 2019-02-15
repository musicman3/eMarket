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

// ОБРАБАТЫВАЕМ HEADER
if ($VALID->inPOST('layout_header') OR $VALID->inPOST('layout_header_basket')) {
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'header']);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'header-basket']);

    for ($x = 0; $x < count($VALID->inPOST('layout_header')); $x++) {
        if ($VALID->inPOST('layout_header')[$x] == 'header') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/' . $VALID->inPOST('layout_header')[$x] . '.php', 'catalog', 'header', 'all', $x]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_header')[$x] . '.php', 'catalog', 'header', 'all', $x]);
        }
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_header_basket')); $x++) {
        if ($VALID->inPOST('layout_header_basket')[$x] == 'header') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/' . $VALID->inPOST('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', 'all', $x]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', 'all', $x]);
        }
    }
}
// ОБРАБАТЫВАЕМ CONTENT
if ($VALID->inPOST('layout_content') OR $VALID->inPOST('layout_content_basket')) {
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'content']);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'content-basket']);

    for ($x = 0; $x < count($VALID->inPOST('layout_content')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_content')[$x] . '.php', 'catalog', 'content', 'all', $x]);
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_content_basket')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_content_basket')[$x] . '.php', 'catalog', 'content-basket', 'all', $x]);
    }
}

// ОБРАБАТЫВАЕМ BOXES
if ($VALID->inPOST('layout_boxes_left') OR $VALID->inPOST('layout_boxes_right') OR $VALID->inPOST('layout_boxes_basket')) {
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'boxes-left']);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'boxes-right']);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'boxes-basket']);

    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_left')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_left')[$x] . '.php', 'catalog', 'boxes-left', 'all', $x]);
    }
    
    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_right')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_right')[$x] . '.php', 'catalog', 'boxes-right', 'all', $x]);
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_basket')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_basket')[$x] . '.php', 'catalog', 'boxes-basket', 'all', $x]);
    }
}

// ОБРАБАТЫВАЕМ FOOTER
if ($VALID->inPOST('layout_footer') OR $VALID->inPOST('layout_footer_basket')) {
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'footer']);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=?", ['catalog', 'footer-basket']);

    for ($x = 0; $x < count($VALID->inPOST('layout_footer')); $x++) {
        if ($VALID->inPOST('layout_footer')[$x] == 'footer') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/' . $VALID->inPOST('layout_footer')[$x] . '.php', 'catalog', 'footer', 'all', $x]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_footer')[$x] . '.php', 'catalog', 'footer', 'all', $x]);
        }
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_footer_basket')); $x++) {
        if ($VALID->inPOST('layout_footer_basket')[$x] == 'footer') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/' . $VALID->inPOST('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', 'all', $x]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', 'all', $x]);
        }
    }
}

//$DEBUG->trace($layout_pages);
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */

?>