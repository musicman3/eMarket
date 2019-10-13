<?php
/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$layout_pages = scandir(ROOT . '/controller/catalog/pages/');
$name_template = scandir(ROOT . '/view/');

if (\eMarket\Core\Valid::inGET('layout_pages_templates')) {
    if (\eMarket\Core\Valid::inGET('layout_pages_templates') == 'Все страницы') {
        $select_page = 'all';
    } else {
        $select_page = \eMarket\Core\Valid::inGET('layout_pages_templates');
    }
} else {
    $select_page = 'catalog';
}

if (\eMarket\Core\Valid::inGET('name_templates')) {
    $select_template = \eMarket\Core\Valid::inGET('name_templates');
} else {
    $select_template = \eMarket\Core\Set::template();
}



$layout_header_temp = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header', $select_template, $select_page]);
$layout_header_basket_temp = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header-basket', $select_template, $select_page]);

if ($layout_header_temp == NULL && $layout_header_basket_temp == NULL) { // ЕСЛИ ЕЩЕ НЕ БЫЛО ОТДЕЛЬНОЙ КОМПОНОВКИ НА СТРАНИЦУ, ТО ГРУЗИМ КОМПОНОВКУ ИЗ ALL
    $select_page_temp = 'all';
    $layout_header = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header', $select_template, $select_page_temp]);
    $layout_content = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'content', $select_template, $select_page_temp]);
    $layout_boxes_left = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-left', $select_template, $select_page_temp]);
    $layout_boxes_right = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-right', $select_template, $select_page_temp]);
    $layout_footer = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'footer', $select_template, $select_page_temp]);

    $layout_header_basket = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header-basket', $select_template, $select_page_temp]);
    $layout_content_basket = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'content-basket', $select_template, $select_page_temp]);
    $layout_boxes_basket = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-basket', $select_template, $select_page_temp]);
    $layout_footer_basket = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'footer-basket', $select_template, $select_page_temp]);
} else {
    $layout_header = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header', $select_template, $select_page]);
    $layout_content = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'content', $select_template, $select_page]);
    $layout_boxes_left = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-left', $select_template, $select_page]);
    $layout_boxes_right = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-right', $select_template, $select_page]);
    $layout_footer = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'footer', $select_template, $select_page]);

    $layout_header_basket = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'header-basket', $select_template, $select_page]);
    $layout_content_basket = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'content-basket', $select_template, $select_page]);
    $layout_boxes_basket = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'boxes-basket', $select_template, $select_page]);
    $layout_footer_basket = \eMarket\Core\Pdo::getCol("SELECT url FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=? ORDER BY sort ASC", ['catalog', 'footer-basket', $select_template, $select_page]);
}

if (\eMarket\Core\Valid::inGET('layout_header') OR \eMarket\Core\Valid::inGET('layout_header_basket')) {
    if (\eMarket\Core\Valid::inGET('page') == 'Все страницы') {
        $select_page = 'all';

        // ОЧИЩАЕМ ВСЕ СЛОИ ДЛЯ ШАБЛОНА
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'header', \eMarket\Core\Valid::inGET('template')]);
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'header-basket', \eMarket\Core\Valid::inGET('template')]);
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'content', \eMarket\Core\Valid::inGET('template')]);
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'content-basket', \eMarket\Core\Valid::inGET('template')]);
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-left', \eMarket\Core\Valid::inGET('template')]);
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-right', \eMarket\Core\Valid::inGET('template')]);
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'boxes-basket', \eMarket\Core\Valid::inGET('template')]);
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'footer', \eMarket\Core\Valid::inGET('template')]);
        \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=?", ['catalog', 'footer-basket', \eMarket\Core\Valid::inGET('template')]);
    } else {
        $select_page = \eMarket\Core\Valid::inGET('page');
    }

    // ОБРАБАТЫВАЕМ HEADER
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header', \eMarket\Core\Valid::inGET('template'), $select_page]);
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header-basket', \eMarket\Core\Valid::inGET('template'), $select_page]);

    if (empty(\eMarket\Core\Valid::inGET('layout_header')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_header')); $x++) {
            if (\eMarket\Core\Valid::inGET('layout_header')[$x] == 'header') {
                \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Core\Valid::inGET('layout_header')[$x] . '.php', 'catalog', 'header', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            } else {
                \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_header')[$x] . '.php', 'catalog', 'header', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }
    }

    if (empty(\eMarket\Core\Valid::inGET('layout_header_basket')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_header_basket')); $x++) {
            if (\eMarket\Core\Valid::inGET('layout_header_basket')[$x] == 'header') {
                \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Core\Valid::inGET('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            } else {
                \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }
    }

    // ОБРАБАТЫВАЕМ CONTENT
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content', \eMarket\Core\Valid::inGET('template'), $select_page]);
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content-basket', \eMarket\Core\Valid::inGET('template'), $select_page]);

    if (empty(\eMarket\Core\Valid::inGET('layout_content')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_content')); $x++) {
            \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_content')[$x] . '.php', 'catalog', 'content', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
        }
    }

    if (empty(\eMarket\Core\Valid::inGET('layout_content_basket')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_content_basket')); $x++) {
            \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_content_basket')[$x] . '.php', 'catalog', 'content-basket', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
        }
    }

    // ОБРАБАТЫВАЕМ BOXES
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-left', \eMarket\Core\Valid::inGET('template'), $select_page]);
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-right', \eMarket\Core\Valid::inGET('template'), $select_page]);
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-basket', \eMarket\Core\Valid::inGET('template'), $select_page]);

    if (empty(\eMarket\Core\Valid::inGET('layout_boxes_left')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_boxes_left')); $x++) {
            \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_boxes_left')[$x] . '.php', 'catalog', 'boxes-left', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
        }
    }

    if (empty(\eMarket\Core\Valid::inGET('layout_boxes_right')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_boxes_right')); $x++) {
            \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_boxes_right')[$x] . '.php', 'catalog', 'boxes-right', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
        }
    }

    if (empty(\eMarket\Core\Valid::inGET('layout_boxes_basket')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_boxes_basket')); $x++) {
            \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_boxes_basket')[$x] . '.php', 'catalog', 'boxes-basket', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
        }
    }

    // ОБРАБАТЫВАЕМ FOOTER
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer', \eMarket\Core\Valid::inGET('template'), $select_page]);
    \eMarket\Core\Pdo::inPrepare("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer-basket', \eMarket\Core\Valid::inGET('template'), $select_page]);

    if (empty(\eMarket\Core\Valid::inGET('layout_footer')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_footer')); $x++) {
            if (\eMarket\Core\Valid::inGET('layout_footer')[$x] == 'footer') {
                \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Core\Valid::inGET('layout_footer')[$x] . '.php', 'catalog', 'footer', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            } else {
                \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_footer')[$x] . '.php', 'catalog', 'footer', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }
    }

    if (empty(\eMarket\Core\Valid::inGET('layout_footer_basket')) == FALSE) {
        for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_footer_basket')); $x++) {
            if (\eMarket\Core\Valid::inGET('layout_footer_basket')[$x] == 'footer') {
                \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Core\Valid::inGET('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            } else {
                \eMarket\Core\Pdo::inPrepare("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', $select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }
    }
}
//\eMarket\Other\Debug::trace($layout_pages);
//
//Создаем маркер для подгрузки JS/JS.PHP в конце перед </body>
$JS_END = __DIR__;

?>