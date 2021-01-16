<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Templates
 *
 * @package Admin
 * @author eMarket
 * 
 */
class Templates {

    public static $layout_pages;
    public static $name_template;
    public static $select_page;
    public static $select_template;
    public static $layout_header;
    public static $layout_content;
    public static $layout_boxes_left;
    public static $layout_boxes_right;
    public static $layout_footer;
    public static $layout_header_basket;
    public static $layout_content_basket;
    public static $layout_boxes_basket;
    public static $layout_footer_basket;

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->data();
        $this->selectPage();
        $this->selectTemplate();
        $this->loadData();
        $this->handler();
    }

    /**
     * Data
     *
     */
    public function data() {
        self::$layout_pages = scandir(ROOT . '/controller/catalog/pages/');
        self::$name_template = scandir(ROOT . '/view/');
    }

    /**
     * Select Page
     *
     */
    public function selectPage() {
        if (\eMarket\Core\Valid::inGET('layout_pages_templates')) {
            if (\eMarket\Core\Valid::inGET('layout_pages_templates') == 'all') {
                self::$select_page = 'all';
            } else {
                self::$select_page = \eMarket\Core\Valid::inGET('layout_pages_templates');
            }
        } else {
            self::$select_page = 'catalog';
        }
    }

    /**
     * Select Template
     *
     */
    public function selectTemplate() {
        if (\eMarket\Core\Valid::inGET('name_templates')) {
            self::$select_template = \eMarket\Core\Valid::inGET('name_templates');
        } else {
            self::$select_template = \eMarket\Core\Settings::template();
        }
    }

    /**
     * Load Data
     *
     */
    public function loadData() {
        $layouts_data = \eMarket\Core\Pdo::getColAssoc("SELECT url, value, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND template_name=? ORDER BY sort ASC", ['catalog', self::$select_template]);
        $layouts = \eMarket\Core\Func::filterData($layouts_data, 'page', self::$select_page);

        $layout_header_temp = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'header', 'url', 'false');
        $layout_header_basket_temp = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'header-basket', 'url', 'false');

        if ($layout_header_temp == NULL && $layout_header_basket_temp == NULL) {
            $layouts_all = \eMarket\Core\Func::filterData($layouts_data, 'page', 'all');

            self::$layout_header = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'header', 'url', 'false');
            self::$layout_content = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'content', 'url', 'false');
            self::$layout_boxes_left = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'boxes-left', 'url', 'false');
            self::$layout_boxes_right = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'boxes-right', 'url', 'false');
            self::$layout_footer = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'footer', 'url', 'false');

            self::$layout_header_basket = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'header-basket', 'url', 'false');
            self::$layout_content_basket = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'content-basket', 'url', 'false');
            self::$layout_boxes_basket = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'boxes-basket', 'url', 'false');
            self::$layout_footer_basket = \eMarket\Core\Func::filterArrayToKey($layouts_all, 'value', 'footer-basket', 'url', 'false');
        } else {
            self::$layout_header = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'header', 'url', 'false');
            self::$layout_content = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'content', 'url', 'false');
            self::$layout_boxes_left = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'boxes-left', 'url', 'false');
            self::$layout_boxes_right = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'boxes-right', 'url', 'false');
            self::$layout_footer = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'footer', 'url', 'false');

            self::$layout_header_basket = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'header-basket', 'url', 'false');
            self::$layout_content_basket = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'content-basket', 'url', 'false');
            self::$layout_boxes_basket = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'boxes-basket', 'url', 'false');
            self::$layout_footer_basket = \eMarket\Core\Func::filterArrayToKey($layouts, 'value', 'footer-basket', 'url', 'false');
        }
    }

    /**
     * Handler
     *
     */
    public function handler() {

        if (!\eMarket\Core\Valid::inGET('layout_pages_templates')) {
            self::$select_page = 'catalog';
        }

        if (\eMarket\Core\Valid::inGET('layout_header') OR \eMarket\Core\Valid::inGET('layout_header_basket')) {
            if (\eMarket\Core\Valid::inGET('page') == 'all') {
                self::$select_page = 'all';

                \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND template_name=?", ['catalog', \eMarket\Core\Valid::inGET('template')]);
            } else {
                self::$select_page = \eMarket\Core\Valid::inGET('page');
            }

            self::header();
            self::content();
            self::boxes();
            self::footer();
        }
    }

    /**
     * Header
     *
     */
    public function header() {
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header', \eMarket\Core\Valid::inGET('template'), self::$select_page]);
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header-basket', \eMarket\Core\Valid::inGET('template'), self::$select_page]);

        if (empty(\eMarket\Core\Valid::inGET('layout_header')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_header')); $x++) {
                if (\eMarket\Core\Valid::inGET('layout_header')[$x] == 'header') {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Core\Valid::inGET('layout_header')[$x] . '.php', 'catalog', 'header', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
                } else {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_header')[$x] . '.php', 'catalog', 'header', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
                }
            }
        }

        if (empty(\eMarket\Core\Valid::inGET('layout_header_basket')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_header_basket')); $x++) {
                if (\eMarket\Core\Valid::inGET('layout_header_basket')[$x] == 'header') {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Core\Valid::inGET('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
                } else {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
                }
            }
        }
    }

    /**
     * Content
     *
     */
    public function content() {
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content', \eMarket\Core\Valid::inGET('template'), self::$select_page]);
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content-basket', \eMarket\Core\Valid::inGET('template'), self::$select_page]);

        if (empty(\eMarket\Core\Valid::inGET('layout_content')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_content')); $x++) {
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_content')[$x] . '.php', 'catalog', 'content', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }

        if (empty(\eMarket\Core\Valid::inGET('layout_content_basket')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_content_basket')); $x++) {
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_content_basket')[$x] . '.php', 'catalog', 'content-basket', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }
    }

    /**
     * Boxes
     *
     */
    public function boxes() {
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-left', \eMarket\Core\Valid::inGET('template'), self::$select_page]);
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-right', \eMarket\Core\Valid::inGET('template'), self::$select_page]);
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-basket', \eMarket\Core\Valid::inGET('template'), self::$select_page]);

        if (empty(\eMarket\Core\Valid::inGET('layout_boxes_left')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_boxes_left')); $x++) {
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_boxes_left')[$x] . '.php', 'catalog', 'boxes-left', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }

        if (empty(\eMarket\Core\Valid::inGET('layout_boxes_right')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_boxes_right')); $x++) {
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_boxes_right')[$x] . '.php', 'catalog', 'boxes-right', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }

        if (empty(\eMarket\Core\Valid::inGET('layout_boxes_basket')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_boxes_basket')); $x++) {
                \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_boxes_basket')[$x] . '.php', 'catalog', 'boxes-basket', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
            }
        }
    }

    /**
     * Footer
     *
     */
    public function footer() {
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer', \eMarket\Core\Valid::inGET('template'), self::$select_page]);
        \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer-basket', \eMarket\Core\Valid::inGET('template'), self::$select_page]);

        if (empty(\eMarket\Core\Valid::inGET('layout_footer')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_footer')); $x++) {
                if (\eMarket\Core\Valid::inGET('layout_footer')[$x] == 'footer') {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Core\Valid::inGET('layout_footer')[$x] . '.php', 'catalog', 'footer', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
                } else {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_footer')[$x] . '.php', 'catalog', 'footer', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
                }
            }
        }

        if (empty(\eMarket\Core\Valid::inGET('layout_footer_basket')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Core\Valid::inGET('layout_footer_basket')); $x++) {
                if (\eMarket\Core\Valid::inGET('layout_footer_basket')[$x] == 'footer') {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Core\Valid::inGET('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
                } else {
                    \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Core\Valid::inGET('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', self::$select_page, $x, \eMarket\Core\Valid::inGET('template')]);
                }
            }
        }
    }

}
