<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

namespace eMarket\Admin;

/**
 * Slideshow
 *
 * @package Admin
 * @author eMarket
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
    public static function helper() {
        \eMarket\Core\Pages::$start = \eMarket\Core\Pages::$table['navigate'][0];
        \eMarket\Core\Pages::$finish = \eMarket\Core\Pages::$table['navigate'][1];
    }

    /**
     * Menu config
     * [0] - url, [1] - icon, [2] - name, [3] - target="_blank", [4] - submenu (true/false)
     * 
     */
    public static function menu() {
        \eMarket\Admin\HeaderMenu::$menu[\eMarket\Admin\HeaderMenu::$menu_marketing][] = ['?route=slideshow', 'glyphicon glyphicon-film', lang('title_slideshow_index'), '', 'false'];
    }

    /**
     * Settings
     *
     */
    public function settings() {
        self::$settings = json_encode(\eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . "", [])[0]);
    }

    /**
     * Slideshow Pref
     *
     */
    public function slideshowPref() {
        if (\eMarket\Core\Valid::inPOST('slideshow_pref')) {

            if (\eMarket\Core\Valid::inPOST('mouse_stop')) {
                $mouse_stop = 1;
            } else {
                $mouse_stop = 0;
            }
            if (\eMarket\Core\Valid::inPOST('autostart')) {
                $autostart = 1;
            } else {
                $autostart = 0;
            }
            if (\eMarket\Core\Valid::inPOST('cicles')) {
                $cicles = 1;
            } else {
                $cicles = 0;
            }
            if (\eMarket\Core\Valid::inPOST('indicators')) {
                $indicators = 1;
            } else {
                $indicators = 0;
            }
            if (\eMarket\Core\Valid::inPOST('navigation')) {
                $navigation = 1;
            } else {
                $navigation = 0;
            }

            \eMarket\Core\Pdo::action("UPDATE " . TABLE_SLIDESHOW_PREF . " SET show_interval=?, mouse_stop=?, autostart=?, cicles=?, indicators=?, navigation=? WHERE id=?", [\eMarket\Core\Valid::inPOST('show_interval'), $mouse_stop, $autostart, $cicles, $indicators, $navigation, 1]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Add
     *
     */
    public function add() {
        if (\eMarket\Core\Valid::inPOST('add')) {

            if (\eMarket\Core\Valid::inPOST('view_slideshow')) {
                $view_slideshow = '1';
            } else {
                $view_slideshow = '0';
            }

            if (\eMarket\Core\Valid::inPOST('animation')) {
                $animation = '1';
            } else {
                $animation = '0';
            }

            if (\eMarket\Core\Valid::inPOST('start_date')) {
                $start_date = date('Y-m-d', strtotime(\eMarket\Core\Valid::inPOST('start_date')));
            } else {
                $start_date = NULL;
            }

            if (\eMarket\Core\Valid::inPOST('end_date')) {
                $end_date = date('Y-m-d', strtotime(\eMarket\Core\Valid::inPOST('end_date')));
            } else {
                $end_date = NULL;
            }

            \eMarket\Core\Pdo::action("INSERT INTO " . TABLE_SLIDESHOW . " SET language=?, url=?, name=?, heading=?, logo=?, animation=?, color=?, date_start=?, date_finish=?, status=?", [\eMarket\Core\Valid::inPOST('set_language'), \eMarket\Core\Valid::inPOST('url'), \eMarket\Core\Valid::inPOST('name'), \eMarket\Core\Valid::inPOST('heading'), json_encode([]), $animation, \eMarket\Core\Valid::inPOST('color'), $start_date, $end_date, $view_slideshow]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (\eMarket\Core\Valid::inPOST('edit')) {

            if (\eMarket\Core\Valid::inPOST('view_slideshow')) {
                $view_slideshow = '1';
            } else {
                $view_slideshow = '0';
            }

            if (\eMarket\Core\Valid::inPOST('animation')) {
                $animation = '1';
            } else {
                $animation = '0';
            }

            if (\eMarket\Core\Valid::inPOST('start_date')) {
                $start_date = date('Y-m-d', strtotime(\eMarket\Core\Valid::inPOST('start_date')));
            } else {
                $start_date = NULL;
            }

            if (\eMarket\Core\Valid::inPOST('end_date')) {
                $end_date = date('Y-m-d', strtotime(\eMarket\Core\Valid::inPOST('end_date')));
            } else {
                $end_date = NULL;
            }

            \eMarket\Core\Pdo::action("UPDATE " . TABLE_SLIDESHOW . " SET url=?, name=?, heading=?, animation=?, color=?, date_start=?, date_finish=?, status=? WHERE id=?", [\eMarket\Core\Valid::inPOST('url'), \eMarket\Core\Valid::inPOST('name'), \eMarket\Core\Valid::inPOST('heading'), $animation, \eMarket\Core\Valid::inPOST('color'), $start_date, $end_date, $view_slideshow, \eMarket\Core\Valid::inPOST('edit')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Upload Images
     *
     */
    public function imgUpload() {
        // add before delete
        self::$resize_param = [];
        array_push(self::$resize_param, ['125', '63']); // width, height
        array_push(self::$resize_param, ['1200', '600']);
        array_push(self::$resize_param, ['1366', '683']);
        array_push(self::$resize_param, ['1600', '800']);
        array_push(self::$resize_param, ['1920', '960']);

        \eMarket\Core\Files::imgUpload(TABLE_SLIDESHOW, 'slideshow', self::$resize_param);
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Core\Valid::inPOST('delete')) {
            \eMarket\Core\Pdo::action("DELETE FROM " . TABLE_SLIDESHOW . " WHERE id=?", [\eMarket\Core\Valid::inPOST('delete')]);

            \eMarket\Core\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        if (\eMarket\Core\Valid::inGET('slide_lang')) {
            self::$set_language = \eMarket\Core\Valid::inGET('slide_lang');
        } else {
            self::$set_language = lang('#lang_all')[0];
        }

        self::$this_time = time();

        self::$sql_data = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW . " ORDER BY id DESC", []);
        $lines = \eMarket\Core\Func::filterData(self::$sql_data, 'language', self::$set_language);
        \eMarket\Core\Pages::table($lines);
    }

    /**
     * View
     *
     */
    public static function view() {
        self::$slideshow = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW . " WHERE language=? ORDER BY id DESC", [lang('#lang_all')[0]]);
        $slideshow_pref = \eMarket\Core\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . " WHERE id=?", [1])[0];

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
            foreach (json_decode($images_data['logo'], 1) as $logo) {
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
    public function modal() {
        self::$json_data = json_encode([]);
        for ($i = \eMarket\Core\Pages::$start; $i < \eMarket\Core\Pages::$finish; $i++) {
            if (isset(\eMarket\Core\Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = \eMarket\Core\Pages::$table['lines'][$i]['id'];

                foreach (self::$sql_data as $sql_modal) {
                    if ($sql_modal['id'] == $modal_id) {
                        $name[$modal_id] = $sql_modal['name'];
                        $url[$modal_id] = $sql_modal['url'];
                        $heading[$modal_id] = $sql_modal['heading'];
                        $logo[$modal_id] = json_decode($sql_modal['logo'], 1);
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
