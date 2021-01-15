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
        self::$settings = json_encode(\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . "", [])[0]);
    }

    /**
     * Slideshow Pref
     *
     */
    public function slideshowPref() {
        if (\eMarket\Valid::inPOST('slideshow_pref')) {

            if (\eMarket\Valid::inPOST('mouse_stop')) {
                $mouse_stop = 1;
            } else {
                $mouse_stop = 0;
            }
            if (\eMarket\Valid::inPOST('autostart')) {
                $autostart = 1;
            } else {
                $autostart = 0;
            }
            if (\eMarket\Valid::inPOST('cicles')) {
                $cicles = 1;
            } else {
                $cicles = 0;
            }
            if (\eMarket\Valid::inPOST('indicators')) {
                $indicators = 1;
            } else {
                $indicators = 0;
            }
            if (\eMarket\Valid::inPOST('navigation')) {
                $navigation = 1;
            } else {
                $navigation = 0;
            }

            \eMarket\Pdo::action("UPDATE " . TABLE_SLIDESHOW_PREF . " SET show_interval=?, mouse_stop=?, autostart=?, cicles=?, indicators=?, navigation=? WHERE id=?", [\eMarket\Valid::inPOST('show_interval'), $mouse_stop, $autostart, $cicles, $indicators, $navigation, 1]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Add
     *
     */
    public function add() {
        if (\eMarket\Valid::inPOST('add')) {

            if (\eMarket\Valid::inPOST('view_slideshow')) {
                $view_slideshow = '1';
            } else {
                $view_slideshow = '0';
            }

            if (\eMarket\Valid::inPOST('animation')) {
                $animation = '1';
            } else {
                $animation = '0';
            }

            if (\eMarket\Valid::inPOST('start_date')) {
                $start_date = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('start_date')));
            } else {
                $start_date = NULL;
            }

            if (\eMarket\Valid::inPOST('end_date')) {
                $end_date = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('end_date')));
            } else {
                $end_date = NULL;
            }

            \eMarket\Pdo::action("INSERT INTO " . TABLE_SLIDESHOW . " SET language=?, url=?, name=?, heading=?, logo=?, animation=?, color=?, date_start=?, date_finish=?, status=?", [\eMarket\Valid::inPOST('set_language'), \eMarket\Valid::inPOST('url'), \eMarket\Valid::inPOST('name'), \eMarket\Valid::inPOST('heading'), json_encode([]), $animation, \eMarket\Valid::inPOST('color'), $start_date, $end_date, $view_slideshow]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Edit
     *
     */
    public function edit() {
        if (\eMarket\Valid::inPOST('edit')) {

            if (\eMarket\Valid::inPOST('view_slideshow')) {
                $view_slideshow = '1';
            } else {
                $view_slideshow = '0';
            }

            if (\eMarket\Valid::inPOST('animation')) {
                $animation = '1';
            } else {
                $animation = '0';
            }

            if (\eMarket\Valid::inPOST('start_date')) {
                $start_date = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('start_date')));
            } else {
                $start_date = NULL;
            }

            if (\eMarket\Valid::inPOST('end_date')) {
                $end_date = date('Y-m-d', strtotime(\eMarket\Valid::inPOST('end_date')));
            } else {
                $end_date = NULL;
            }

            \eMarket\Pdo::action("UPDATE " . TABLE_SLIDESHOW . " SET url=?, name=?, heading=?, animation=?, color=?, date_start=?, date_finish=?, status=? WHERE id=?", [\eMarket\Valid::inPOST('url'), \eMarket\Valid::inPOST('name'), \eMarket\Valid::inPOST('heading'), $animation, \eMarket\Valid::inPOST('color'), $start_date, $end_date, $view_slideshow, \eMarket\Valid::inPOST('edit')]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
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

        \eMarket\Files::imgUpload(TABLE_SLIDESHOW, 'slideshow', self::$resize_param);
    }

    /**
     * Delete
     *
     */
    public function delete() {
        if (\eMarket\Valid::inPOST('delete')) {
            \eMarket\Pdo::action("DELETE FROM " . TABLE_SLIDESHOW . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

            \eMarket\Messages::alert('success', lang('action_completed_successfully'));
        }
    }

    /**
     * Data
     *
     */
    public function data() {
        if (\eMarket\Valid::inGET('slide_lang')) {
            self::$set_language = \eMarket\Valid::inGET('slide_lang');
        } else {
            self::$set_language = lang('#lang_all')[0];
        }

        self::$this_time = time();

        self::$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW . " ORDER BY id DESC", []);
        $lines = \eMarket\Func::filterData(self::$sql_data, 'language', self::$set_language);
        \eMarket\Pages::table($lines);
    }

    /**
     * Modal
     *
     */
    public function modal() {
        self::$json_data = json_encode([]);
        for ($i = \eMarket\Pages::$start; $i < \eMarket\Pages::$finish; $i++) {
            if (isset(\eMarket\Pages::$table['lines'][$i]['id']) == TRUE) {

                $modal_id = \eMarket\Pages::$table['lines'][$i]['id'];

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
