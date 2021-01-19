<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

use \eMarket\Core\{
    Func,
    Pdo,
    Settings,
    Valid
};

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
        if (Valid::inGET('layout_pages_templates')) {
            if (Valid::inGET('layout_pages_templates') == 'all') {
                self::$select_page = 'all';
            } else {
                self::$select_page = Valid::inGET('layout_pages_templates');
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
        if (Valid::inGET('name_templates')) {
            self::$select_template = Valid::inGET('name_templates');
        } else {
            self::$select_template = Settings::template();
        }
    }

    /**
     * Load Data
     *
     */
    public function loadData() {
        $layouts_data = Pdo::getColAssoc("SELECT url, value, page FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND template_name=? ORDER BY sort ASC", ['catalog', self::$select_template]);
        $layouts = Func::filterData($layouts_data, 'page', self::$select_page);

        $layout_header_temp = Func::filterArrayToKey($layouts, 'value', 'header', 'url', 'false');
        $layout_header_basket_temp = Func::filterArrayToKey($layouts, 'value', 'header-basket', 'url', 'false');

        if ($layout_header_temp == NULL && $layout_header_basket_temp == NULL) {
            $layouts_all = Func::filterData($layouts_data, 'page', 'all');

            self::$layout_header = Func::filterArrayToKey($layouts_all, 'value', 'header', 'url', 'false');
            self::$layout_content = Func::filterArrayToKey($layouts_all, 'value', 'content', 'url', 'false');
            self::$layout_boxes_left = Func::filterArrayToKey($layouts_all, 'value', 'boxes-left', 'url', 'false');
            self::$layout_boxes_right = Func::filterArrayToKey($layouts_all, 'value', 'boxes-right', 'url', 'false');
            self::$layout_footer = Func::filterArrayToKey($layouts_all, 'value', 'footer', 'url', 'false');

            self::$layout_header_basket = Func::filterArrayToKey($layouts_all, 'value', 'header-basket', 'url', 'false');
            self::$layout_content_basket = Func::filterArrayToKey($layouts_all, 'value', 'content-basket', 'url', 'false');
            self::$layout_boxes_basket = Func::filterArrayToKey($layouts_all, 'value', 'boxes-basket', 'url', 'false');
            self::$layout_footer_basket = Func::filterArrayToKey($layouts_all, 'value', 'footer-basket', 'url', 'false');
        } else {
            self::$layout_header = Func::filterArrayToKey($layouts, 'value', 'header', 'url', 'false');
            self::$layout_content = Func::filterArrayToKey($layouts, 'value', 'content', 'url', 'false');
            self::$layout_boxes_left = Func::filterArrayToKey($layouts, 'value', 'boxes-left', 'url', 'false');
            self::$layout_boxes_right = Func::filterArrayToKey($layouts, 'value', 'boxes-right', 'url', 'false');
            self::$layout_footer = Func::filterArrayToKey($layouts, 'value', 'footer', 'url', 'false');

            self::$layout_header_basket = Func::filterArrayToKey($layouts, 'value', 'header-basket', 'url', 'false');
            self::$layout_content_basket = Func::filterArrayToKey($layouts, 'value', 'content-basket', 'url', 'false');
            self::$layout_boxes_basket = Func::filterArrayToKey($layouts, 'value', 'boxes-basket', 'url', 'false');
            self::$layout_footer_basket = Func::filterArrayToKey($layouts, 'value', 'footer-basket', 'url', 'false');
        }
    }

    /**
     * Handler
     *
     */
    public function handler() {

        if (!Valid::inGET('layout_pages_templates')) {
            self::$select_page = 'catalog';
        }

        if (Valid::inGET('layout_header') OR Valid::inGET('layout_header_basket')) {
            if (Valid::inGET('page') == 'all') {
                self::$select_page = 'all';

                Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND template_name=?", ['catalog', Valid::inGET('template')]);
            } else {
                self::$select_page = Valid::inGET('page');
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
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header', Valid::inGET('template'), self::$select_page]);
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'header-basket', Valid::inGET('template'), self::$select_page]);

        if (Valid::inGET('layout_header')) {
            for ($x = 0; $x < count(Valid::inGET('layout_header')); $x++) {
                if (Valid::inGET('layout_header')[$x] == 'header') {
                    Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . Valid::inGET('layout_header')[$x] . '.php', 'catalog', 'header', self::$select_page, $x, Valid::inGET('template')]);
                } else {
                    Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_header')[$x] . '.php', 'catalog', 'header', self::$select_page, $x, Valid::inGET('template')]);
                }
            }
        }

        if (Valid::inGET('layout_header_basket')) {
            for ($x = 0; $x < count(Valid::inGET('layout_header_basket')); $x++) {
                if (Valid::inGET('layout_header_basket')[$x] == 'header') {
                    Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . Valid::inGET('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', self::$select_page, $x, Valid::inGET('template')]);
                } else {
                    Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_header_basket')[$x] . '.php', 'catalog', 'header-basket', self::$select_page, $x, Valid::inGET('template')]);
                }
            }
        }
    }

    /**
     * Content
     *
     */
    public function content() {
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content', Valid::inGET('template'), self::$select_page]);
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'content-basket', Valid::inGET('template'), self::$select_page]);

        if (Valid::inGET('layout_content')) {
            for ($x = 0; $x < count(Valid::inGET('layout_content')); $x++) {
                Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_content')[$x] . '.php', 'catalog', 'content', self::$select_page, $x, Valid::inGET('template')]);
            }
        }

        if (Valid::inGET('layout_content_basket')) {
            for ($x = 0; $x < count(Valid::inGET('layout_content_basket')); $x++) {
                Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_content_basket')[$x] . '.php', 'catalog', 'content-basket', self::$select_page, $x, Valid::inGET('template')]);
            }
        }
    }

    /**
     * Boxes
     *
     */
    public function boxes() {
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-left', Valid::inGET('template'), self::$select_page]);
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-right', Valid::inGET('template'), self::$select_page]);
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'boxes-basket', Valid::inGET('template'), self::$select_page]);

        if (Valid::inGET('layout_boxes_left')) {
            for ($x = 0; $x < count(Valid::inGET('layout_boxes_left')); $x++) {
                Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_boxes_left')[$x] . '.php', 'catalog', 'boxes-left', self::$select_page, $x, Valid::inGET('template')]);
            }
        }

        if (Valid::inGET('layout_boxes_right')) {
            for ($x = 0; $x < count(Valid::inGET('layout_boxes_right')); $x++) {
                Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_boxes_right')[$x] . '.php', 'catalog', 'boxes-right', self::$select_page, $x, Valid::inGET('template')]);
            }
        }

        if (Valid::inGET('layout_boxes_basket')) {
            for ($x = 0; $x < count(Valid::inGET('layout_boxes_basket')); $x++) {
                Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_boxes_basket')[$x] . '.php', 'catalog', 'boxes-basket', self::$select_page, $x, Valid::inGET('template')]);
            }
        }
    }

    /**
     * Footer
     *
     */
    public function footer() {
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer', Valid::inGET('template'), self::$select_page]);
        Pdo::action("DELETE FROM " . TABLE_TEMPLATE_CONSTRUCTOR . " WHERE group_id=? AND value=? AND template_name=? AND page=?", ['catalog', 'footer-basket', Valid::inGET('template'), self::$select_page]);

        if (Valid::inGET('layout_footer')) {
            for ($x = 0; $x < count(Valid::inGET('layout_footer')); $x++) {
                if (Valid::inGET('layout_footer')[$x] == 'footer') {
                    Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . Valid::inGET('layout_footer')[$x] . '.php', 'catalog', 'footer', self::$select_page, $x, Valid::inGET('template')]);
                } else {
                    Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_footer')[$x] . '.php', 'catalog', 'footer', self::$select_page, $x, Valid::inGET('template')]);
                }
            }
        }

        if (Valid::inGET('layout_footer_basket')) {
            for ($x = 0; $x < count(Valid::inGET('layout_footer_basket')); $x++) {
                if (Valid::inGET('layout_footer_basket')[$x] == 'footer') {
                    Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/' . Valid::inGET('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', self::$select_page, $x, Valid::inGET('template')]);
                } else {
                    Pdo::action("INSERT INTO " . TABLE_TEMPLATE_CONSTRUCTOR . " SET url=?, group_id=?, value=?, page=?, sort=?, template_name=?", ['/controller/catalog/layouts/' . Valid::inGET('layout_footer_basket')[$x] . '.php', 'catalog', 'footer-basket', self::$select_page, $x, Valid::inGET('template')]);
                }
            }
        }
    }

}
