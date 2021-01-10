<?php

/* =-=-=-= Copyright © 2018 eMarket =-=-=-=  
  |    GNU GENERAL PUBLIC LICENSE v.3.0    |
  |  https://github.com/musicman3/eMarket  |
  =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-= */

$settings = json_encode(\eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW_PREF . "", [])[0]);

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

// add before delete
$resize_param = [];
array_push($resize_param, ['125', '63']); // width, height
array_push($resize_param, ['1200', '600']);
array_push($resize_param, ['1366', '683']);
array_push($resize_param, ['1600', '800']);
array_push($resize_param, ['1920', '960']);

\eMarket\Files::imgUpload(TABLE_SLIDESHOW, 'slideshow', $resize_param);

if (\eMarket\Valid::inPOST('delete')) {
    \eMarket\Pdo::action("DELETE FROM " . TABLE_SLIDESHOW . " WHERE id=?", [\eMarket\Valid::inPOST('delete')]);

    \eMarket\Messages::alert('success', lang('action_completed_successfully'));
}

if (\eMarket\Valid::inGET('slide_lang')) {
    $set_language = \eMarket\Valid::inGET('slide_lang');
} else {
    $set_language = lang('#lang_all')[0];
}

$this_time = time();

$sql_data = \eMarket\Pdo::getColAssoc("SELECT * FROM " . TABLE_SLIDESHOW . " ORDER BY id DESC", []);
$lines = \eMarket\Func::filterData($sql_data, 'language', $set_language);
$lines_on_page = \eMarket\Settings::linesOnPage();
$count_lines = count($lines);
$navigate = \eMarket\Navigation::getLink($count_lines, $lines_on_page);
$start = $navigate[0];
$finish = $navigate[1];

require_once('modal/index.php');
require_once('modal/settings.php');
