<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Func,
    Settings,
    Valid
};
use Cruder\Cruder;

/**
 * Templates
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Templates {

    public static $routing_parameter = 'templates';
    public $title = 'title_templates_index';
    public $db;
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
        $this->db = new Cruder();
        $this->data();
        $this->selectPage();
        $this->selectTemplate();
        $this->loadData();
        $this->handler();
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_settings][] = ['?route=templates', 'bi-intersect', lang('title_templates_index'), '', 'false'];
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$layout_pages = scandir(ROOT . '/view/' . Settings::template() . '/catalog/pages/');
        self::$name_template = scandir(ROOT . '/view/');
    }

    /**
     * Select Page
     *
     */
    private function selectPage(): void {
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
    private function selectTemplate(): void {
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
    private function loadData(): void {
        $layouts_data = $this->db
                ->read(TABLE_TEMPLATE_CONSTRUCTOR)
                ->selectAssoc('url, value, page')
                ->where('group_id=', 'catalog')
                ->and('template_name=', self::$select_template)
                ->orderByAsc('sort')
                ->save();

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
    private function handler(): void {

        if (!Valid::inGET('layout_pages_templates')) {
            self::$select_page = 'catalog';
        }

        if (Valid::inPostJson('layout_header') OR Valid::inPostJson('layout_header_basket')) {
            if (Valid::inPostJson('page') == 'all') {
                self::$select_page = 'all';

                $this->db
                        ->delete(TABLE_TEMPLATE_CONSTRUCTOR)
                        ->where('group_id=', 'catalog')
                        ->and('template_name=', Valid::inPostJson('template'))
                        ->save();
            } else {
                self::$select_page = Valid::inPostJson('page');
            }

            $this->header();
            $this->content();
            $this->boxes();
            $this->footer();
        }
    }

    /**
     * Clear
     *
     * @param string $value Value
     */
    private function clear(string $value): void {
        $this->db
                ->delete(TABLE_TEMPLATE_CONSTRUCTOR)
                ->where('group_id=', 'catalog')
                ->and('value=', $value)
                ->and('template_name=', Valid::inPostJson('template'))
                ->and('page=', self::$select_page)
                ->save();
    }

    /**
     * Set
     *
     * @param string $url url
     * @param string $value Value
     * @param string $x sort number
     */
    private function set(string $url, string $value, int $x): void {
        $this->db
                ->create(TABLE_TEMPLATE_CONSTRUCTOR)
                ->set('url', $url)
                ->set('group_id', 'catalog')
                ->set('value', $value)
                ->set('page', self::$select_page)
                ->set('sort', $x)
                ->set('template_name', Valid::inPostJson('template'))
                ->save();
    }

    /**
     * Header
     *
     */
    private function header(): void {

        $this->clear('header');
        $this->clear('header-basket');

        if (Valid::inPostJson('layout_header')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_header')); $x++) {

                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_header')[$x] . '.php';

                if (Valid::inPostJson('layout_header')[$x] == 'header') {
                    $url = '/controller/catalog/' . Valid::inPostJson('layout_header')[$x] . '.php';
                }

                $this->set($url, 'header', $x);
            }
        }

        if (Valid::inPostJson('layout_header_basket')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_header_basket')); $x++) {

                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_header_basket')[$x] . '.php';

                if (Valid::inPostJson('layout_header_basket')[$x] == 'header') {
                    $url = '/controller/catalog/' . Valid::inPostJson('layout_header_basket')[$x] . '.php';
                }

                $this->set($url, 'header-basket', $x);
            }
        }
    }

    /**
     * Content
     *
     */
    private function content(): void {

        $this->clear('content');
        $this->clear('content-basket');

        if (Valid::inPostJson('layout_content')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_content')); $x++) {
                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_content')[$x] . '.php';
                $this->set($url, 'content', $x);
            }
        }

        if (Valid::inPostJson('layout_content_basket')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_content_basket')); $x++) {
                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_content_basket')[$x] . '.php';
                $this->set($url, 'content-basket', $x);
            }
        }
    }

    /**
     * Boxes
     *
     */
    private function boxes(): void {

        $this->clear('boxes-left');
        $this->clear('boxes-right');
        $this->clear('boxes-basket');

        if (Valid::inPostJson('layout_boxes_left')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_boxes_left')); $x++) {
                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_boxes_left')[$x] . '.php';
                $this->set($url, 'boxes-left', $x);
            }
        }

        if (Valid::inPostJson('layout_boxes_right')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_boxes_right')); $x++) {
                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_boxes_right')[$x] . '.php';
                $this->set($url, 'boxes-right', $x);
            }
        }

        if (Valid::inPostJson('layout_boxes_basket')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_boxes_basket')); $x++) {
                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_boxes_basket')[$x] . '.php';
                $this->set($url, 'boxes-basket', $x);
            }
        }
    }

    /**
     * Footer
     *
     */
    private function footer(): void {

        $this->clear('footer');
        $this->clear('footer-basket');

        if (Valid::inPostJson('layout_footer')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_footer')); $x++) {

                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_footer')[$x] . '.php';

                if (Valid::inPostJson('layout_footer')[$x] == 'footer') {
                    $url = '/controller/catalog/' . Valid::inPostJson('layout_footer')[$x] . '.php';
                }

                $this->set($url, 'footer', $x);
            }
        }

        if (Valid::inPostJson('layout_footer_basket')) {
            for ($x = 0; $x < count(Valid::inPostJson('layout_footer_basket')); $x++) {

                $url = '/controller/catalog/layouts/' . Valid::inPostJson('layout_footer_basket')[$x] . '.php';

                if (Valid::inPostJson('layout_footer_basket')[$x] == 'footer') {
                    $url = '/controller/catalog/' . Valid::inPostJson('layout_footer_basket')[$x] . '.php';
                }

                $this->set($url, 'footer-basket', $x);
            }
        }
    }

}
