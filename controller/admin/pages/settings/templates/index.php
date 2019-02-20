<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

/* >-->-->-->  CONNECT PAGE START  <--<--<--< */
require_once(getenv('DOCUMENT_ROOT') . '/model/start.php');
/* ------------------------------------------ */

$layout_pages = scandir(ROOT . '/controller/catalog/pages/');
$name_template = scandir(ROOT . '/view/');

$layout_header = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'header', $SET->template()]);
$layout_content = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'content', $SET->template()]);
$layout_boxes_left = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'boxes-left', $SET->template()]);
$layout_boxes_right = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'boxes-right', $SET->template()]);
$layout_footer = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'footer', $SET->template()]);

$layout_header_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'header-basket', $SET->template()]);
$layout_content_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'content-basket', $SET->template()]);
$layout_boxes_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'boxes-basket', $SET->template()]);
$layout_footer_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? ORDER BY sort ASC", ['catalog', 'footer-basket', $SET->template()]);

// ОБРАБАТЫВАЕМ HEADER
if ($VALID->inPOST('layout_header') OR $VALID->inPOST('layout_header_basket')) {
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'header', $VALID->inPOST('template')]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'header-basket', $VALID->inPOST('template')]);

    for ($x = 0; $x < count($VALID->inPOST('layout_header')); $x++) {
        if ($VALID->inPOST('layout_header')[$x] == 'header') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . $VALID->inPOST('layout_header')[$x] . '.php', 'catalog', 'header', 'all', $x, $VALID->inPOST('template')]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_header')[$x] . '.php', 'catalog', 'header', 'all', $x, $VALID->inPOST('template')]);
        }
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_header_basket')); $x++) {
        if ($VALID->inPOST('layout_header_basket')[$x] == 'header') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . $VALID->inPOST('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', 'all', $x, $VALID->inPOST('template')]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', 'all', $x, $VALID->inPOST('template')]);
        }
    }
}
// ОБРАБАТЫВАЕМ CONTENT
if ($VALID->inPOST('layout_content') OR $VALID->inPOST('layout_content_basket')) {
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'content', $VALID->inPOST('template')]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'content-basket', $VALID->inPOST('template')]);

    for ($x = 0; $x < count($VALID->inPOST('layout_content')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_content')[$x] . '.php', 'catalog', 'content', 'all', $x, $VALID->inPOST('template')]);
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_content_basket')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_content_basket')[$x] . '.php', 'catalog', 'content-basket', 'all', $x, $VALID->inPOST('template')]);
    }
}

// ОБРАБАТЫВАЕМ BOXES
if ($VALID->inPOST('layout_boxes_left') OR $VALID->inPOST('layout_boxes_right') OR $VALID->inPOST('layout_boxes_basket')) {
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-left', $VALID->inPOST('template')]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-right', $VALID->inPOST('template')]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-basket', $VALID->inPOST('template')]);

    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_left')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_left')[$x] . '.php', 'catalog', 'boxes-left', 'all', $x, $VALID->inPOST('template')]);
    }
    
    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_right')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_right')[$x] . '.php', 'catalog', 'boxes-right', 'all', $x, $VALID->inPOST('template')]);
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_basket')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_basket')[$x] . '.php', 'catalog', 'boxes-basket', 'all', $x, $VALID->inPOST('template')]);
    }
}

// ОБРАБАТЫВАЕМ FOOTER
if ($VALID->inPOST('layout_footer') OR $VALID->inPOST('layout_footer_basket')) {
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'footer', $VALID->inPOST('template')]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'footer-basket', $VALID->inPOST('template')]);

    for ($x = 0; $x < count($VALID->inPOST('layout_footer')); $x++) {
        if ($VALID->inPOST('layout_footer')[$x] == 'footer') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . $VALID->inPOST('layout_footer')[$x] . '.php', 'catalog', 'footer', 'all', $x, $VALID->inPOST('template')]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_footer')[$x] . '.php', 'catalog', 'footer', 'all', $x, $VALID->inPOST('template')]);
        }
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_footer_basket')); $x++) {
        if ($VALID->inPOST('layout_footer_basket')[$x] == 'footer') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . $VALID->inPOST('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', 'all', $x, $VALID->inPOST('template')]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', 'all', $x, $VALID->inPOST('template')]);
        }
    }
}

//$DEBUG->trace($layout_pages);
//
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

/* ->-->-->-->  CONNECT PAGE END  <--<--<--<- */
require_once(ROOT . '/model/end.php');
/* ------------------------------------------ */

?>