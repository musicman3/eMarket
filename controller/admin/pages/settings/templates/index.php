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

if ($VALID->inPOST('layout_pages_templates')) {
    if ($VALID->inPOST('layout_pages_templates') == 'Все страницы') {
        $select_page = 'all';
    } else {
        $select_page = $VALID->inPOST('layout_pages_templates');
    }
} else {
    $select_page = 'all';
}

if ($VALID->inPOST('name_templates')) {
    $select_template = $VALID->inPOST('name_templates');
} else {
    $select_template = $SET->template();
}



$layout_header_temp = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header', $select_template, $select_page]);
$layout_header_basket_temp = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header-basket', $select_template, $select_page]);

if ($layout_header_temp == NULL && $layout_header_basket_temp == NULL) { // ЕСЛИ ЕЩЕ НЕ БЫЛО ОТДЕЛЬНОЙ КОМПОНОВКИ НА СТРАНИЦУ, ТО ГРУЗИМ КОМПОНОВКУ ИЗ ALL
    $select_page_temp = 'all';
    $layout_header = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header', $select_template, $select_page_temp]);
    $layout_content = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'content', $select_template, $select_page_temp]);
    $layout_boxes_left = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-left', $select_template, $select_page_temp]);
    $layout_boxes_right = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-right', $select_template, $select_page_temp]);
    $layout_footer = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'footer', $select_template, $select_page_temp]);

    $layout_header_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header-basket', $select_template, $select_page_temp]);
    $layout_content_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'content-basket', $select_template, $select_page_temp]);
    $layout_boxes_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-basket', $select_template, $select_page_temp]);
    $layout_footer_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'footer-basket', $select_template, $select_page_temp]);
} else {
    $layout_header = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header', $select_template, $select_page]);
    $layout_content = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'content', $select_template, $select_page]);
    $layout_boxes_left = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-left', $select_template, $select_page]);
    $layout_boxes_right = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-right', $select_template, $select_page]);
    $layout_footer = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'footer', $select_template, $select_page]);

    $layout_header_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header-basket', $select_template, $select_page]);
    $layout_content_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'content-basket', $select_template, $select_page]);
    $layout_boxes_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-basket', $select_template, $select_page]);
    $layout_footer_basket = $PDO->getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'footer-basket', $select_template, $select_page]);
}

if ($VALID->inPOST('layout_header') OR $VALID->inPOST('layout_header_basket')) {
    if ($VALID->inPOST('page') == 'Все страницы') {
        $select_page = 'all';

        // ОЧИЩАЕМ ВСЕ СЛОИ ДЛЯ ШАБЛОНА
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'header', $VALID->inPOST('template')]);
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'header-basket', $VALID->inPOST('template')]);
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'content', $VALID->inPOST('template')]);
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'content-basket', $VALID->inPOST('template')]);
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-left', $VALID->inPOST('template')]);
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-right', $VALID->inPOST('template')]);
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-basket', $VALID->inPOST('template')]);
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'footer', $VALID->inPOST('template')]);
        $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'footer-basket', $VALID->inPOST('template')]);
    } else {
        $select_page = $VALID->inPOST('page');
    }

    // ОБРАБАТЫВАЕМ HEADER
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header', $VALID->inPOST('template'), $select_page]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header-basket', $VALID->inPOST('template'), $select_page]);

    for ($x = 0; $x < count($VALID->inPOST('layout_header')); $x++) {
        if ($VALID->inPOST('layout_header')[$x] == 'header') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . $VALID->inPOST('layout_header')[$x] . '.php', 'catalog', 'header', $select_page, $x, $VALID->inPOST('template')]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_header')[$x] . '.php', 'catalog', 'header', $select_page, $x, $VALID->inPOST('template')]);
        }
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_header_basket')); $x++) {
        if ($VALID->inPOST('layout_header_basket')[$x] == 'header') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . $VALID->inPOST('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', $select_page, $x, $VALID->inPOST('template')]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', $select_page, $x, $VALID->inPOST('template')]);
        }
    }

    // ОБРАБАТЫВАЕМ CONTENT
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content', $VALID->inPOST('template'), $select_page]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content-basket', $VALID->inPOST('template'), $select_page]);

    for ($x = 0; $x < count($VALID->inPOST('layout_content')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_content')[$x] . '.php', 'catalog', 'content', $select_page, $x, $VALID->inPOST('template')]);
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_content_basket')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_content_basket')[$x] . '.php', 'catalog', 'content-basket', $select_page, $x, $VALID->inPOST('template')]);
    }

    // ОБРАБАТЫВАЕМ BOXES
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-left', $VALID->inPOST('template'), $select_page]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-right', $VALID->inPOST('template'), $select_page]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-basket', $VALID->inPOST('template'), $select_page]);

    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_left')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_left')[$x] . '.php', 'catalog', 'boxes-left', $select_page, $x, $VALID->inPOST('template')]);
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_right')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_right')[$x] . '.php', 'catalog', 'boxes-right', $select_page, $x, $VALID->inPOST('template')]);
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_boxes_basket')); $x++) {
        $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_boxes_basket')[$x] . '.php', 'catalog', 'boxes-basket', $select_page, $x, $VALID->inPOST('template')]);
    }

    // ОБРАБАТЫВАЕМ FOOTER
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer', $VALID->inPOST('template'), $select_page]);
    $PDO->inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer-basket', $VALID->inPOST('template'), $select_page]);

    for ($x = 0; $x < count($VALID->inPOST('layout_footer')); $x++) {
        if ($VALID->inPOST('layout_footer')[$x] == 'footer') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . $VALID->inPOST('layout_footer')[$x] . '.php', 'catalog', 'footer', $select_page, $x, $VALID->inPOST('template')]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_footer')[$x] . '.php', 'catalog', 'footer', $select_page, $x, $VALID->inPOST('template')]);
        }
    }

    for ($x = 0; $x < count($VALID->inPOST('layout_footer_basket')); $x++) {
        if ($VALID->inPOST('layout_footer_basket')[$x] == 'footer') {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . $VALID->inPOST('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', $select_page, $x, $VALID->inPOST('template')]);
        } else {
            $PDO->inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . $VALID->inPOST('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', $select_page, $x, $VALID->inPOST('template')]);
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