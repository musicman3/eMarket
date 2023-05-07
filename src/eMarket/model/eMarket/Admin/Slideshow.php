<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Clock\SystemClock,
    Cache,
    Images,
    Func,
    Messages,
    Pages,
    Valid,
};
use eMarket\Admin\HeaderMenu;
use Cruder\Db;

/**
 * Slideshow
 *
 * @package Admin
 * @author eMarket Team
 * @copyright © 2018 eMarket
 * @license GNU GPL v.3.0
 * 
 */
class Slideshow {

    public static $routing_parameter = 'slideshow';
    public $title = 'title_slideshow_index';
    public static $sql_data = FALSE;
    public static $json_data = FALSE;
    public static $settings = FALSE;
    public static $resize_param = FALSE;
    public static $this_time = FALSE;
    public static $set_language = FALSE;
    public static $slideshow;
    public static $slide_interval;
    public static $slide_pause;
    public static $autostart;
    public static $cicles;
    public static $indicators;
    public static $navigation_key;
    public static $slideshow_array = [];

    /**
     * Constructor
     *
     */
    function __construct() {
        $this->settings();
        $this->slideshowPref();
        $this->add();
        $this->edit();
        $this->imgUpload();
        $this->delete();
        $this->data();
        $this->modal();
    }

    /**
     * Helper
     * 
     */
    public static function helper(): void {
        Pages::$start = Pages::$table['navigate'][0];
        Pages::$finish = Pages::$table['navigate'][1];
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu(): void {
        HeaderMenu::$menu[HeaderMenu::$menu_marketing][] = ['?route=slideshow', 'bi-film', lang('title_slideshow_index'), '', 'false'];
    }

    /**
     * Settings
     *
     */
    private function settings(): void {

        $settings = Db::connect()
                ->read(TABLE_SLIDESHOW_PREF)
                ->selectAssoc('*')
                ->save();

        self::$settings = json_encode($settings[0]);
    }

    /**
     * Slideshow Pref
     *
     */
    private function slideshowPref(): void {
        if (Valid::inPOST('slideshow_pref')) {
            $mouse_stop = 0;
            $autostart = 0;
            $cicles = 0;
            $indicators = 0;
            $navigation = 0;

            if (Valid::inPOST('mouse_stop')) {
                $mouse_stop = 1;
            }
            if (Valid::inPOST('autostart')) {
                $autostart = 1;
            }
            if (Valid::inPOST('cicles')) {
                $cicles = 1;
            }
            if (Valid::inPOST('indicators')) {
                $indicators = 1;
            }
            if (Valid::inPOST('navigation')) {
                $navigation = 1;
            }

            Db::connect()
                    ->update(TABLE_SLIDESHOW_PREF)
                    ->set('show_interval', Valid::inPOST('show_interval'))
                    ->set('mouse_stop', $mouse_stop)
                    ->set('autostart', $autostart)
                    ->set('cicles', $cicles)
                    ->set('indicators', $indicators)
                    ->set('navigation', $navigation)
                    ->where('id=', 1)
                    ->save();

            Messages::alert('slideshow_pref edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Add
     *
     */
    private function add(): void {
        if (Valid::inPOST('add')) {
            $status = '0';
            $animation = '0';
            $start_date = NULL;
            $end_date = NULL;

            if (Valid::inPOST('view_slideshow')) {
                $status = '1';
            }

            if (Valid::inPOST('animation')) {
                $animation = '1';
            }

            if (Valid::inPOST('start_date')) {
                $start_date = SystemClock::getSqlDateTime(Valid::inPOST('start_date'));
            }

            if (Valid::inPOST('end_date')) {
                $end_date = SystemClock::getSqlDateTime(Valid::inPOST('end_date'));
            }

            Db::connect()
                    ->create(TABLE_SLIDESHOW)
                    ->set('language', Valid::inPOST('set_language'))
                    ->set('url', Valid::inPOST('url'))
                    ->set('name', Valid::inPOST('name'))
                    ->set('heading', Valid::inPOST('heading'))
                    ->set('logo', json_encode([]))
                    ->set('animation', $animation)
                    ->set('color', Valid::inPOST('color'))
                    ->set('date_start', $start_date)
                    ->set('date_finish', $end_date)
                    ->set('status', $status)
                    ->save();

            $Cache = new Cache();
            $Cache->deleteItem('catalog.slideshow');

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    private function edit(): void {
        if (Valid::inPOST('edit')) {
            $status = '0';
            $animation = '0';
            $start_date = NULL;
            $end_date = NULL;

            if (Valid::inPOST('view_slideshow')) {
                $status = '1';
            }

            if (Valid::inPOST('animation')) {
                $animation = '1';
            }

            if (Valid::inPOST('start_date')) {
                $start_date = SystemClock::getSqlDateTime(Valid::inPOST('start_date'));
            }

            if (Valid::inPOST('end_date')) {
                $end_date = SystemClock::getSqlDateTime(Valid::inPOST('end_date'));
            }

            Db::connect()
                    ->update(TABLE_SLIDESHOW)
                    ->set('url', Valid::inPOST('url'))
                    ->set('name', Valid::inPOST('name'))
                    ->set('heading', Valid::inPOST('heading'))
                    ->set('animation', $animation)
                    ->set('color', Valid::inPOST('color'))
                    ->set('date_start', $start_date)
                    ->set('date_finish', $end_date)
                    ->set('status', $status)
                    ->where('id=', Valid::inPOST('edit'))
                    ->save();

            $Cache = new Cache();
            $Cache->deleteItem('catalog.slideshow');

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Upload Images
     *
     */
    private function imgUpload(): void {
        // add before delete
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '63']); // width, height
        array_push(self::$resize_param, ['1200', '600']);
        array_push(self::$resize_param, ['1366', '683']);
        array_push(self::$resize_param, ['1600', '800']);
        array_push(self::$resize_param, ['1920', '960']);

        new Images(TABLE_SLIDESHOW, 'slideshow', self::$resize_param);
    }

    /**
     * Delete
     *
     */
    private function delete(): void {
        if (Valid::inPOST('delete')) {

            Db::connect()
                    ->delete(TABLE_SLIDESHOW)
                    ->where('id=', Valid::inPOST('delete'))
                    ->save();

            $Cache = new Cache();
            $Cache->deleteItem('catalog.slideshow');

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    private function data(): void {
        self::$set_language = lang('#lang_all')[0];
        if (Valid::inGET('slide_lang')) {
            self::$set_language = Valid::inGET('slide_lang');
        }

        self::$this_time = SystemClock::nowUnixTime();

        self::$sql_data = Db::connect()
                ->read(TABLE_SLIDESHOW)
                ->selectAssoc('*')
                ->orderByDesc('id')
                ->save();

        $lines = Func::filterData(self::$sql_data, 'language', self::$set_language);
        Pages::data($lines);
    }

    /**
     * Modal
     *
     */
    private function modal(): void {
        self::$json_data = json_encode([]);
        for ($i = Pages::$start; $i < Pages::$finish; $i++) {
            if (isset(Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[$modal_id] = $sql_modal['name'];
                        $url[$modal_id] = $sql_modal['url'];
                        $heading[$modal_id] = $sql_modal['heading'];
                        $logo[$modal_id] = json_decode($sql_modal['logo'], true);
                        $logo_general[$modal_id] = $sql_modal['logo_general'];
                        $animation[$modal_id] = (int) $sql_modal['animation'];
                        $color[$modal_id] = $sql_modal['color'];
                        $heading[$modal_id] = $sql_modal['heading'];
                        $date_start[$modal_id] = $sql_modal['date_start'];
                        $date_finish[$modal_id] = $sql_modal['date_finish'];
                        $status[$modal_id] = (int) $sql_modal['status'];
                    }
                }

                self::$json_data = json_encode([
                    'name' => $name,
                    'url' => $url,
                    'heading' => $heading,
                    'logo' => $logo,
                    'logo_general' => $logo_general,
                    'animation' => $animation,
                    'color' => $color,
                    'date_start' => $date_start,
                    'date_finish' => $date_finish,
                    'status' => $status
                ]);
            }
        }
    }

    /**
     * View
     *
     */
    public static function view(): void {

        $Cache = new Cache();
        $Cache->cache_name = 'catalog.slideshow';

        if (!$Cache->isHit()) {

            $Cache->data = Db::connect()
                    ->read(TABLE_SLIDESHOW)
                    ->selectAssoc('*')
                    ->where('language=', lang('#lang_all')[0])
                    ->orderByDesc('id')
                    ->save();

            self::$slideshow = $Cache->save($Cache->data);
        } else {
            self::$slideshow = $Cache->cache_item->get();
        }

        $slideshow_pref = Db::connect()
                        ->read(TABLE_SLIDESHOW_PREF)
                        ->selectAssoc('*')
                        ->where('id=', 1)
                        ->save()[0];

        self::$slide_interval = $slideshow_pref['show_interval'];
        self::$slide_pause = 'false';
        self::$autostart = 'false';
        self::$cicles = 'false';
        self::$indicators = 'false';
        self::$navigation_key = 'false';

        if ($slideshow_pref['mouse_stop'] == 1) {
            self::$slide_pause = 'hover';
        }

        if ($slideshow_pref['autostart'] == 1) {
            self::$autostart = 'carousel';
        }

        if ($slideshow_pref['cicles'] == 1) {
            self::$cicles = 'true';
        }

        if ($slideshow_pref['indicators'] == 1) {
            self::$indicators = 'true';
        }

        if ($slideshow_pref['navigation'] == 1) {
            self::$navigation_key = 'true';
        }

        self::$this_time = SystemClock::nowUnixTime();

        foreach (self::$slideshow as $images_data) {
            foreach (json_decode($images_data['logo'], true) as $logo) {
                if ($images_data['status'] == '1' && SystemClock::getUnixTime($images_data['date_start']) <= self::$this_time && SystemClock::getUnixTime($images_data['date_finish']) >= self::$this_time) {
                    array_push(self::$slideshow_array, $logo);
                }
            }
        }
    }

}
