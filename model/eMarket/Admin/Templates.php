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
        if (\eMarket\Valid::inGET('layout_pages_templates')) {
            if (\eMarket\Valid::inGET('layout_pages_templates') == 'all') {
                self::$select_page = 'all';
            } else {
                self::$select_page = \eMarket\Valid::inGET('layout_pages_templates');
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
        if (\eMarket\Valid::inGET('name_templates')) {
            self::$select_template = \eMarket\Valid::inGET('name_templates');
        } else {
            self::$select_template = \eMarket\Settings::template();
        }
    }

    /**
     * Load Data
     *
     */
    public function loadData() {
        $layouts_data = \eMarket\Pdo::getColAssoc("SELECT url, value, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND template_name=? ORDER BY sort ASC", ['catalog', self::$select_template]);
        $layouts = \eMarket\Func::filterData($layouts_data, 'page', self::$select_page);

        $layout_header_temp = \eMarket\Func::filterArrayToKey($layouts, 'value', 'header', 'url', 'false');
        $layout_header_basket_temp = \eMarket\Func::filterArrayToKey($layouts, 'value', 'header-basket', 'url', 'false');

        if ($layout_header_temp == NULL && $layout_header_basket_temp == NULL) {
            $layouts_all = \eMarket\Func::filterData($layouts_data, 'page', 'all');

            self::$layout_header = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'header', 'url', 'false');
            self::$layout_content = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'content', 'url', 'false');
            self::$layout_boxes_left = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'boxes-left', 'url', 'false');
            self::$layout_boxes_right = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'boxes-right', 'url', 'false');
            self::$layout_footer = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'footer', 'url', 'false');

            self::$layout_header_basket = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'header-basket', 'url', 'false');
            self::$layout_content_basket = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'content-basket', 'url', 'false');
            self::$layout_boxes_basket = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'boxes-basket', 'url', 'false');
            self::$layout_footer_basket = \eMarket\Func::filterArrayToKey($layouts_all, 'value', 'footer-basket', 'url', 'false');
        } else {
            self::$layout_header = \eMarket\Func::filterArrayToKey($layouts, 'value', 'header', 'url', 'false');
            self::$layout_content = \eMarket\Func::filterArrayToKey($layouts, 'value', 'content', 'url', 'false');
            self::$layout_boxes_left = \eMarket\Func::filterArrayToKey($layouts, 'value', 'boxes-left', 'url', 'false');
            self::$layout_boxes_right = \eMarket\Func::filterArrayToKey($layouts, 'value', 'boxes-right', 'url', 'false');
            self::$layout_footer = \eMarket\Func::filterArrayToKey($layouts, 'value', 'footer', 'url', 'false');

            self::$layout_header_basket = \eMarket\Func::filterArrayToKey($layouts, 'value', 'header-basket', 'url', 'false');
            self::$layout_content_basket = \eMarket\Func::filterArrayToKey($layouts, 'value', 'content-basket', 'url', 'false');
            self::$layout_boxes_basket = \eMarket\Func::filterArrayToKey($layouts, 'value', 'boxes-basket', 'url', 'false');
            self::$layout_footer_basket = \eMarket\Func::filterArrayToKey($layouts, 'value', 'footer-basket', 'url', 'false');
        }
    }

    /**
     * Handler
     *
     */
    public function handler() {

        if (!\eMarket\Valid::inGET('layout_pages_templates')) {
            self::$select_page = 'catalog';
        }

        if (\eMarket\Valid::inGET('layout_header') OR \eMarket\Valid::inGET('layout_header_basket')) {
            if (\eMarket\Valid::inGET('page') == 'all') {
                self::$select_page = 'all';

                \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND template_name=?", ['catalog', \eMarket\Valid::inGET('template')]);
            } else {
                self::$select_page = \eMarket\Valid::inGET('page');
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
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header', \eMarket\Valid::inGET('template'), self::$select_page]);
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header-basket', \eMarket\Valid::inGET('template'), self::$select_page]);

        if (empty(\eMarket\Valid::inGET('layout_header')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_header')); $x++) {
                if (\eMarket\Valid::inGET('layout_header')[$x] == 'header') {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Valid::inGET('layout_header')[$x] . '.php', 'catalog', 'header', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
                } else {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_header')[$x] . '.php', 'catalog', 'header', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
                }
            }
        }

        if (empty(\eMarket\Valid::inGET('layout_header_basket')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_header_basket')); $x++) {
                if (\eMarket\Valid::inGET('layout_header_basket')[$x] == 'header') {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Valid::inGET('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
                } else {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
                }
            }
        }
    }

    /**
     * Content
     *
     */
    public function content() {
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content', \eMarket\Valid::inGET('template'), self::$select_page]);
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content-basket', \eMarket\Valid::inGET('template'), self::$select_page]);

        if (empty(\eMarket\Valid::inGET('layout_content')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_content')); $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_content')[$x] . '.php', 'catalog', 'content', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
            }
        }

        if (empty(\eMarket\Valid::inGET('layout_content_basket')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_content_basket')); $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_content_basket')[$x] . '.php', 'catalog', 'content-basket', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
            }
        }
    }

    /**
     * Boxes
     *
     */
    public function boxes() {
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-left', \eMarket\Valid::inGET('template'), self::$select_page]);
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-right', \eMarket\Valid::inGET('template'), self::$select_page]);
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-basket', \eMarket\Valid::inGET('template'), self::$select_page]);

        if (empty(\eMarket\Valid::inGET('layout_boxes_left')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_boxes_left')); $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_boxes_left')[$x] . '.php', 'catalog', 'boxes-left', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
            }
        }

        if (empty(\eMarket\Valid::inGET('layout_boxes_right')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_boxes_right')); $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_boxes_right')[$x] . '.php', 'catalog', 'boxes-right', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
            }
        }

        if (empty(\eMarket\Valid::inGET('layout_boxes_basket')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_boxes_basket')); $x++) {
                \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_boxes_basket')[$x] . '.php', 'catalog', 'boxes-basket', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
            }
        }
    }

    /**
     * Footer
     *
     */
    public function footer() {
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer', \eMarket\Valid::inGET('template'), self::$select_page]);
        \eMarket\Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer-basket', \eMarket\Valid::inGET('template'), self::$select_page]);

        if (empty(\eMarket\Valid::inGET('layout_footer')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_footer')); $x++) {
                if (\eMarket\Valid::inGET('layout_footer')[$x] == 'footer') {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Valid::inGET('layout_footer')[$x] . '.php', 'catalog', 'footer', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
                } else {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_footer')[$x] . '.php', 'catalog', 'footer', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
                }
            }
        }

        if (empty(\eMarket\Valid::inGET('layout_footer_basket')) == FALSE) {
            for ($x = 0; $x < count(\eMarket\Valid::inGET('layout_footer_basket')); $x++) {
                if (\eMarket\Valid::inGET('layout_footer_basket')[$x] == 'footer') {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . \eMarket\Valid::inGET('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
                } else {
                    \eMarket\Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . \eMarket\Valid::inGET('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', self::$select_page, $x, \eMarket\Valid::inGET('template')]);
                }
            }
        }
    }

}
