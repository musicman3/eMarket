<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Clock\SystemClock,
    Func,
    Settings,
    Valid,
    Routing
};
use Cruder\Db;
use eMarket\Admin\HeaderMenu;

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
    public static $layout_pages;
    public static $name_template;
    public static $tpl_cfg;
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
    public static $catalog_button_selected = '';
    public static $array_pos_value = 'false';

    /**
     * Constructor
     *
     */
    function __construct() {
        new HeaderMenu();
        $this->data();
        $this->selectPage();
        $this->selectTemplate();
        $this->loadData();
        $this->handler();
        $this->saveConfig();
        $this->deleteConfig();
        $this->setConfig();
        $this->catalogButton();
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
        self::$tpl_cfg = scandir(ROOT . '/storage/tpl_cfg/');
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
     * Clear
     *
     * @param string $value Value
     */
    private function clear(string $value): void {
        Db::connect()
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
        Db::connect()
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
     * Builder
     *
     * @param string $url url
     * @param string $value Value
     * @param string $x sort number
     */
    private function builder(string $layout_data, string $layout): void {
        if (Valid::inPostJson($layout_data)) {
            for ($x = 0; $x < count(Valid::inPostJson($layout_data)); $x++) {
                $url = '/controller/catalog/layouts/' . Valid::inPostJson($layout_data)[$x] . '.php';
                $this->set($url, $layout, $x);
            }
        }
    }

    /**
     * Load Data
     *
     */
    private function loadData(): void {
        $layouts_data = Db::connect()
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
            $layouts = Func::filterData($layouts_data, 'page', 'all');
        }

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

                Db::connect()
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
     * Header
     *
     */
    private function header(): void {
        $this->clear('header');
        $this->clear('header-basket');
        $this->builder('layout_header', 'header');
        $this->builder('layout_header_basket', 'header-basket');
    }

    /**
     * Content
     *
     */
    private function content(): void {
        $this->clear('content');
        $this->clear('content-basket');
        $this->builder('layout_content', 'content');
        $this->builder('layout_content_basket', 'content-basket');
    }

    /**
     * Boxes
     *
     */
    private function boxes(): void {
        $this->clear('boxes-left');
        $this->clear('boxes-right');
        $this->clear('boxes-basket');
        $this->builder('layout_boxes_left', 'boxes-left');
        $this->builder('layout_boxes_right', 'boxes-right');
        $this->builder('layout_boxes_basket', 'boxes-basket');
    }

    /**
     * Footer
     *
     */
    private function footer(): void {
        $this->clear('footer');
        $this->clear('footer-basket');
        $this->builder('layout_footer', 'footer');
        $this->builder('layout_footer_basket', 'footer-basket');
    }

    /**
     * Save config
     *
     */
    private function saveConfig(): void {
        if (Valid::inPostJson('save_config') == 'ok') {

            $data = Db::connect()
                    ->read(TABLE_TEMPLATE_CONSTRUCTOR)
                    ->selectAssoc('*')
                    ->where('group_id=', 'catalog')
                    ->and('template_name=', Valid::inPostJson('template_name'))
                    ->save();

            if (Valid::inPostJson('config_input')) {
                file_put_contents(ROOT . '/storage/tpl_cfg/' . Valid::inPostJson('config_input') . '.tcg', json_encode($data));
            } else {
                file_put_contents(ROOT . '/storage/tpl_cfg/' . SystemClock::nowFormatDate('Y-m-d_H-i-s') . '.tcg', json_encode($data));
            }
        }
    }

    /**
     * Show Catalog button
     *
     */
    private function catalogButton(): void {


        $other = json_decode(Settings::basicSettings('other'), true);

        if (isset($other['catalog_button']) && $other['catalog_button'] == 'on') {
            self::$catalog_button_selected = 'checked';
        }

        if (Valid::inPostJson('catalog_button') == 'ok') {
            if (!isset($other['catalog_button']) || $other['catalog_button'] == 'off') {
                $other['catalog_button'] = 'on';
            } else {
                $other['catalog_button'] = 'off';
            }

            Db::connect()
                    ->update(TABLE_BASIC_SETTINGS)
                    ->set('other', json_encode($other))
                    ->save();
        }
    }

    /**
     * Delete config
     *
     */
    private function deleteConfig(): void {
        if (Valid::inPostJson('delete_config') == 'ok') {
            unlink(ROOT . '/storage/tpl_cfg/' . Valid::inPostJson('config_name') . '.tcg');
        }
    }

    /**
     * Set config
     *
     */
    private function setConfig(): void {
        if (Valid::inPostJson('set_config') == 'ok') {

            $data = json_decode(file(ROOT . '/storage/tpl_cfg/' . Valid::inPostJson('config_name') . '.tcg')[0], true);

            Db::connect()
                    ->delete(TABLE_TEMPLATE_CONSTRUCTOR)
                    ->where('group_id=', 'catalog')
                    ->and('template_name=', $data[0]['template_name'])
                    ->save();

            foreach ($data as $value) {
                Db::connect()
                        ->create(TABLE_TEMPLATE_CONSTRUCTOR)
                        ->set('url', $value['url'])
                        ->set('group_id', $value['group_id'])
                        ->set('value', $value['value'])
                        ->set('page', $value['page'])
                        ->set('template_name', $value['template_name'])
                        ->set('sort', $value['sort'])
                        ->save();
            }
        }
    }

    /**
     * Template Layers Positioning Controller
     *
     * @param string $position (position)
     * @param string $count (counter marker)
     * @return int|array|string (positions for paths)
     */
    public static function tlpc(string $position, ?string $count = null): int|string|array {

        $page = Routing::routingPath();

        if (self::$array_pos_value == 'false') {
            self::$array_pos_value = Db::connect()
                    ->read(TABLE_TEMPLATE_CONSTRUCTOR)
                    ->selectIndex('url, value')
                    ->where('group_id=', Settings::path())
                    ->and('page=', $page)
                    ->and('template_name=', Settings::template())
                    ->orderByAsc('sort')
                    ->save();
        }

        if (count(self::$array_pos_value) > 0) {
            $array_out = [];
            foreach (self::$array_pos_value as $val) {
                if ($val[1] == $position) {
                    $array_out[] = str_replace('controller', 'view/' . Settings::template(), $val[0]);
                }
            }
            if ($count == 'count') {
                return count($array_out);
            }
            return $array_out;
        } else {

            $array_pos = Db::connect()
                    ->read(TABLE_TEMPLATE_CONSTRUCTOR)
                    ->selectIndex('url, page')
                    ->where('group_id=', Settings::path())
                    ->and('value=', $position)
                    ->and('template_name=', Settings::template())
                    ->orderByAsc('sort')
                    ->save();

            $array_out = [];
            foreach ($array_pos as $val) {
                if ($val[1] == 'all') {
                    $array_out[] = str_replace('controller', 'view/' . Settings::template(), $val[0]);
                }
            }
            if ($count == 'count') {
                return count($array_out);
            }
            return $array_out;
        }
    }
}
