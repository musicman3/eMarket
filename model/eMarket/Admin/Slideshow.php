<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

declare(strict_types=1);

namespace eMarket\Admin;

use eMarket\Core\{
    Files,
    Func,
    Messages,
    Pages,
    Pdo,
    Valid,
};
use eMarket\Admin\HeaderMenu;

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
    public function settings(): void {
        self::$settings = json_encode(Pdo::getAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . "", [])[0]);
    }

    /**
     * Slideshow Pref
     *
     */
    public function slideshowPref(): void {
        if (Valid::inPOST('slideshow_pref')) {

            if (Valid::inPOST('mouse_stop')) {
                $mouse_stop = 1;
            } else {
                $mouse_stop = 0;
            }
            if (Valid::inPOST('autostart')) {
                $autostart = 1;
            } else {
                $autostart = 0;
            }
            if (Valid::inPOST('cicles')) {
                $cicles = 1;
            } else {
                $cicles = 0;
            }
            if (Valid::inPOST('indicators')) {
                $indicators = 1;
            } else {
                $indicators = 0;
            }
            if (Valid::inPOST('navigation')) {
                $navigation = 1;
            } else {
                $navigation = 0;
            }

            Pdo::action("UPDATE " . TABLE_SLIDESHOW_PREF . " SET show_interval=?, mouse_stop=?, autostart=?, cicles=?, indicators=?, navigation=? WHERE id=?", [
                Valid::inPOST('show_interval'), $mouse_stop, $autostart, $cicles, $indicators, $navigation, 1
            ]);

            Messages::alert('slideshow_pref edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Add
     *
     */
    public function add(): void {
        if (Valid::inPOST('add')) {

            if (Valid::inPOST('view_slideshow')) {
                $view_slideshow = '1';
            } else {
                $view_slideshow = '0';
            }

            if (Valid::inPOST('animation')) {
                $animation = '1';
            } else {
                $animation = '0';
            }

            if (Valid::inPOST('start_date')) {
                $start_date = date('Y-m-d', strtotime(Valid::inPOST('start_date')));
            } else {
                $start_date = NULL;
            }

            if (Valid::inPOST('end_date')) {
                $end_date = date('Y-m-d', strtotime(Valid::inPOST('end_date')));
            } else {
                $end_date = NULL;
            }

            Pdo::action("INSERT INTO " . TABLE_SLIDESHOW . " SET language=?, url=?, name=?, heading=?, logo=?, animation=?, color=?, date_start=?, date_finish=?, status=?", [
                Valid::inPOST('set_language'), Valid::inPOST('url'), Valid::inPOST('name'),
                Valid::inPOST('heading'), json_encode([]), $animation, Valid::inPOST('color'),
                $start_date, $end_date, $view_slideshow
            ]);

            Messages::alert('add', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit(): void {
        if (Valid::inPOST('edit')) {

            if (Valid::inPOST('view_slideshow')) {
                $view_slideshow = '1';
            } else {
                $view_slideshow = '0';
            }

            if (Valid::inPOST('animation')) {
                $animation = '1';
            } else {
                $animation = '0';
            }

            if (Valid::inPOST('start_date')) {
                $start_date = date('Y-m-d', strtotime(Valid::inPOST('start_date')));
            } else {
                $start_date = NULL;
            }

            if (Valid::inPOST('end_date')) {
                $end_date = date('Y-m-d', strtotime(Valid::inPOST('end_date')));
            } else {
                $end_date = NULL;
            }

            Pdo::action("UPDATE " . TABLE_SLIDESHOW . " SET url=?, name=?, heading=?, animation=?, color=?, date_start=?, date_finish=?, status=? WHERE id=?", [
                Valid::inPOST('url'), Valid::inPOST('name'), Valid::inPOST('heading'), $animation,
                Valid::inPOST('color'), $start_date, $end_date, $view_slideshow, Valid::inPOST('edit')
            ]);

            Messages::alert('edit', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Upload Images
     *
     */
    public function imgUpload(): void {
        // add before delete
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '63']); // width, height
        array_push(self::$resize_param, ['1200', '600']);
        array_push(self::$resize_param, ['1366', '683']);
        array_push(self::$resize_param, ['1600', '800']);
        array_push(self::$resize_param, ['1920', '960']);

        Files::imgUpload(TABLE_SLIDESHOW, 'slideshow', self::$resize_param);
    }

    /**
     * Delete
     *
     */
    public function delete(): void {
        if (Valid::inPOST('delete')) {
            Pdo::action("DELETE FROM " . TABLE_SLIDESHOW . " WHERE id=?", [Valid::inPOST('delete')]);

            Messages::alert('delete', 'success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data(): void {
        if (Valid::inGET('slide_lang')) {
            self::$set_language = Valid::inGET('slide_lang');
        } else {
            self::$set_language = lang('#lang_all')[0];
        }

        self::$this_time = time();

        self::$sql_data = Pdo::getAssoc("SELECT * FROM " . TABLE_SLIDESHOW . " ORDER BY id DESC", []);
        $lines = Func::filterData(self::$sql_data, 'language', self::$set_language);
        Pages::data($lines);
    }

    /**
     * View
     *
     */
    public static function view(): void {
        self::$slideshow = Pdo::getAssoc("SELECT * FROM " . TABLE_SLIDESHOW . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
        $slideshow_pref = Pdo::getAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . " WHERE id=?", [1])[0];

        self::$slide_interval = $slideshow_pref['show_interval'];

        if ($slideshow_pref['mouse_stop'] == 1) {
            self::$slide_pause = 'hover';
        } else {
            self::$slide_pause = 'false';
        }

        if ($slideshow_pref['autostart'] == 1) {
            self::$autostart = 'carousel';
        } else {
            self::$autostart = 'false';
        }

        if ($slideshow_pref['cicles'] == 1) {
            self::$cicles = 'true';
        } else {
            self::$cicles = 'false';
        }

        if ($slideshow_pref['indicators'] == 1) {
            self::$indicators = 'true';
        } else {
            self::$indicators = 'false';
        }

        if ($slideshow_pref['navigation'] == 1) {
            self::$navigation_key = 'true';
        } else {
            self::$navigation_key = 'false';
        }

        self::$this_time = time();

        foreach (self::$slideshow as $images_data) {
            foreach (json_decode($images_data['logo'], true) as $logo) {
                if ($images_data['status'] == '1' && strtotime($images_data['date_start']) <= self::$this_time && strtotime($images_data['date_finish']) >= self::$this_time) {
                    array_push(self::$slideshow_array, $logo);
                }
            }
        }
    }

    /**
     * Modal
     *
     */
    public function modal(): void {
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

}
